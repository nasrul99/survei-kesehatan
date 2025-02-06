<?php

namespace App\Filament\Masyarakat\Pages;

use Filament\Forms\Set;
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
use Filament\Forms\Components\Textarea;


class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.masyarakat.pages.profile';
    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public Masyarakat $masyarakat;

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
                            ->inlineLabel('Jenis Kelamin')
                            ->required()
                            ->options([
                                'L' => 'Laki-Laki',
                                'P' => 'Perempuan',
                            ]),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d/m/Y')
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state, Forms\Get $get) {
                                if ($state) {
                                    $age = now()->diffInYears(\Carbon\Carbon::parse($state));  // Menghitung umur berdasarkan tanggal lahir
                                    $set('umur', $age);
                                } else {
                                    $set('umur', null);
                                }
                            }),

                        Forms\Components\TextInput::make('umur')
                            ->numeric()
                            ->readonly(),
                        Forms\Components\Fieldset::make('Akun Anda')
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
                Forms\Components\Section::make('Foto Masyarakat')
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
