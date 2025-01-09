<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralLabel = 'Pegawai';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Master Data';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
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

                        Forms\Components\Select::make('divisi_id')
                            ->label('Divisi')
                            ->relationship('divisi', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),
                        /*
                        Forms\Components\Select::make('user_id')
                            ->label('User Account')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        */

                        Forms\Components\TextInput::make('user.email')
                            ->maxLength(100)
                            ->email()
                            ->required(fn($get, $record) => $record === null) // Required only when creating a new user
                            ->helperText(fn($record) => $record ? 'Kosongkan untuk mempertahankan email saat ini.' : '') // Only show helper text in edit mode
                            ->default(fn($record) => $record ? $record->user->email : null), // Use existing email in edit mode

                        Forms\Components\TextInput::make('user.password')
                            ->password()
                            ->revealable()
                            ->rule(Password::default())
                            ->dehydrateStateUsing(
                                static fn(?string $state): ?string => filled($state) ? Hash::make($state) : null,
                            )
                            ->dehydrated(static fn(?string $state): bool => filled($state)) // Only update password if a new one is provided
                            ->live(debounce: 500)
                            ->label('Password Baru')
                            ->required(fn($get, $record) => $record === null) // Required only when creating a new user
                            ->helperText(fn($record) => $record ? 'Kosongkan untuk mempertahankan password saat ini.' : ''), // Only show helper text in edit mode


                    ])->columns(2)->columnSpan(2),
                Forms\Components\Section::make('Foto Pegawai')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label(false)
                            ->directory('foto-pegawai')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->circleCropper()
                            ->openable(),
                        //->columnSpanFull(),

                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->sortable()
                    ->searchable(),
                /*
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                */
                Tables\Columns\TextColumn::make('umur')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                /*
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                */
                Tables\Columns\TextColumn::make('divisi.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latestFisik.tinggi_badan')
                    ->label('Tinggi Badan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('latestFisik.berat_badan')
                    ->label('Berat Badan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('latestFisik.imt')
                    ->label('IMT')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => number_format($state, 2)), // Tampilkan dengan 2 angka desimal
                Tables\Columns\TextColumn::make('latestFisik.kondisi_fisik')
                    ->label('Kondisi Fisik')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
            'pemeriksaan_fisik' => Pages\PemeriksaanFisik::route('/{record}/pemeriksaan_fisik'),
            'pemeriksaan_asam_urat' => Pages\PemeriksaanAsamUrat::route('/{record}/pemeriksaan_asam_urat'),
            'pemeriksaan_kolesterol' => Pages\PemeriksaanKolesterol::route('/{record}/pemeriksaan_kolesterol'),
            'pemeriksaan_tekanan_darah' => Pages\PemeriksaanTekananDarah::route('/{record}/pemeriksaan_tekanan_darah'),
            'pemeriksaan_gula_darah' => Pages\PemeriksaanGulaDarah::route('/{record}/pemeriksaan_gula_darah'),

        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\PemeriksaanFisik::class,
            Pages\PemeriksaanAsamUrat::class,
            Pages\PemeriksaanKolesterol::class,
            Pages\PemeriksaanTekananDarah::class,
            Pages\PemeriksaanGulaDarah::class,
        ]);
    }


}
