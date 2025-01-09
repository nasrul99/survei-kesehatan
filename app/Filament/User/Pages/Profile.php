<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Masyarakat;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Js;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Set;



class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.user.pages.profile';
    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public Masyarakat $masyarakat;
    protected ?string $subheading = 'Harap Lengkapi Data Diri Anda !';

    public static function getLabel(): string
    {
        return 'Profile';
    }

    public function mount(): void
    {
        $this->masyarakat = Masyarakat::with('user')
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $this->data = $this->masyarakat->toArray();

        $this->form->fill($this->data);
    }


    public function save(): void
    {
        try {
            //$data = $this->data;
            $data = $this->form->getState();

            $user = $this->masyarakat->user;
            $user->name = $data['nama'];
            //hitung imt
            $imt = $data['berat_badan']/(pow($data['tinggi_badan']/100,2));
            $data['imt'] = $imt;
            $user->save();

            $this->masyarakat->update($data);
        } catch (Halt $exception) {
            return;
        }

        if (request()->hasSession() && isset($user->password)) {
            request()->session()->put([
                'password_hash_' . Filament::getAuthGuard() => $user->password,
            ]);
        }

        $this->data['user']['password'] = null;

        // send notification
        Notification::make()
            ->title('Tersimpan')
            ->body('Profile berhasil disimpan')
            ->success()
            ->send();
    }


    public function form(Form $form): Form
    {
        return $form
            ->model($this->masyarakat)
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nama')->maxLength(255)->required(),
                        Forms\Components\Radio::make('gender')
                            ->label('Jenis Kelamin')
                            ->inline()
                            ->required()
                            ->options([
                                'L' => 'Laki-Laki',
                                'P' => 'Perempuan',
                            ]),
                        Forms\Components\TextInput::make('umur')
                            ->label('Umur')
                            ->numeric()->required(),
                        Forms\Components\TextInput::make('berat_badan')
                            ->label('Berat Badan')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('tinggi_badan')
                            ->label('Tinggi Badan')
                            ->numeric()->required(),

                        Forms\Components\Group::make()
                            ->relationship('user')
                            ->schema([
                                Forms\Components\TextInput::make('email')->maxLength(100)->email()->unique(ignoreRecord: true)->required(),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->rule(Password::default())
                                    ->dehydrateStateUsing(
                                        static fn(null|string $state): null|string => filled($state) ? Hash::make($state) : null,
                                    )->dehydrated(
                                        static fn(null|string $state): bool => filled($state),
                                    )
                                    ->live(debounce: 500)
                                    ->label('New password'),
                            ]),
                    ])->columns(2)->columnSpan(2),
                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label(false)
                            ->directory('foto-masyarakat')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->circleCropper()
                            ->openable(),
                        //->columnSpanFull(),

                    ])->columnSpan(1),
            ])->columns(3)
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->submit('save'),
            Action::make('back')
                ->label(__('filament-panels::pages/auth/edit-profile.actions.cancel.label'))
                ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from(filament()->getUrl()) . ')')
                ->color('gray')
        ];
    }
}
