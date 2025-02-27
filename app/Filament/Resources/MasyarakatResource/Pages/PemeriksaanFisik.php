<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;


class PemeriksaanFisik extends ManageRelatedRecords
{
    protected static string $resource = MasyarakatResource::class;

    protected static string $relationship = 'fisik';

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationLabel(): string
    {
        return 'Fisik';
    }

//    public function getSubheading(): ?string
//    {
//        return 'Pemeriksaan Fisik Masyarakat a/n ' . $this->record->nama . ' - Divisi ' . $this->record->divisi->nama;
//    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Pemeriksaan')
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required()
                            ->displayFormat('d/m/Y'),
                        Forms\Components\TextInput::make('berat_badan')
                            ->label('Berat Badan')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->required(),
                        Forms\Components\TextInput::make('tinggi_badan')
                            ->label('Tinggi Badan')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->recordTitleAttribute('tanggal')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('d-m-Y')),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->label('Tinggi Badan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->label('Berat Badan')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('imt')
                    ->label('IMT')
                    ->formatStateUsing(fn($state) => number_format($state, 2))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kondisi_fisik')
                    ->label('Kondisi Fisik')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['imt'] = $data['berat_badan'] / (pow($data['tinggi_badan'] / 100, 2));
                        $imt = $data['imt'];
                        if ($imt >= 0 && $imt < 18.5) $kondisi = "Kurus";
                        elseif ($imt >= 18.5 && $imt < 25) $kondisi = "Normal";
                        elseif ($imt >= 25 && $imt < 30) $kondisi = "OverWeight";
                        elseif ($imt >= 30 && $imt < 35) $kondisi = "Obesitas 1";
                        elseif ($imt >= 35 && $imt < 40) $kondisi = "Obesitas 2";
                        elseif ($imt > 40) $kondisi = "Obesitas 3";
                        else $kondisi = "-";
                        $data['kondisi_fisik'] = $kondisi;
                        return $data;
                    }),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Pemeriksaan Fisik')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['imt'] = $data['berat_badan'] / (pow($data['tinggi_badan'] / 100, 2));
                        $imt = $data['imt'];
                        if ($imt >= 0 && $imt < 18.5) $kondisi = "Kurus";
                        elseif ($imt >= 18.5 && $imt < 25) $kondisi = "Normal";
                        elseif ($imt >= 25 && $imt < 30) $kondisi = "OverWeight";
                        elseif ($imt >= 30 && $imt < 35) $kondisi = "Obesitas 1";
                        elseif ($imt >= 35 && $imt < 40) $kondisi = "Obesitas 2";
                        elseif ($imt > 40) $kondisi = "Obesitas 3";
                        else $kondisi = "-";
                        $data['kondisi_fisik'] = $kondisi;
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
