<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use App\Models\Kolesterol;
use App\Models\Rekomendasi;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemeriksaanKolesterol extends ManageRelatedRecords
{
    protected static string $resource = PegawaiResource::class;

    protected static string $relationship = 'kolesterol';

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function getNavigationLabel(): string
    {
        return 'Kolesterol Total';
    }

    public function getSubheading(): ?string
    {
        return 'Pemeriksaan Kolesterol Total a/n ' . $this->record->nama . ' - Divisi ' . $this->record->divisi->nama;
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('periode_id')
                            ->label('Periode')
                            ->preload()
                            ->searchable()
                            ->native(false)
                            ->relationship('periode', 'tahun')
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Pemeriksaan')
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required()
                            ->displayFormat('d/m/Y'),
                        Forms\Components\TextInput::make('hasil')
                            ->label('Hasil')
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
                Tables\Columns\TextColumn::make('periode.tahun')
                    ->label('Tahun')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('hasil')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->searchable()->sortable(),
                /*
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->html()
                    ->searchable()->sortable(),
                */
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Input Pemeriksaan Kolesterol Total')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['status'] = $data['hasil'] <= 200 ? "Normal" : "Tinggi";
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Kolesterol')
                            ->where('status', $data['status'])
                            ->first();
                        $data['rekomendasi_id'] = $rekomendasi->id;
                        return $data;
                    }),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Pemeriksaan Kolesterol Total')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['status'] = $data['hasil'] <= 200 ? "Normal" : "Tinggi";
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Kolesterol')
                            ->where('status', $data['status'])
                            ->first();
                        $data['rekomendasi_id'] = $rekomendasi->id;
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
