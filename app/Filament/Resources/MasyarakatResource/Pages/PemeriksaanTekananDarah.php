<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use App\Models\Rekomendasi;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;


class PemeriksaanTekananDarah extends ManageRelatedRecords
{
    protected static string $resource = MasyarakatResource::class;

    protected static string $relationship = 'tekanan_darah';

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function getNavigationLabel(): string
    {
        return 'Tekanan Darah';
    }

//    public function getSubheading(): ?string
//    {
//        return 'Pemeriksaan Tekanan Darah a/n ' . $this->record->nama . ' - Divisi ' . $this->record->divisi->nama;
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
                        Forms\Components\TextInput::make('sistole')
                            ->label('Sistole')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->required(),
                        Forms\Components\TextInput::make('diastole')
                            ->label('Diastole')
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
                Tables\Columns\TextColumn::make('sistole')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('diastole')->searchable()->sortable(),
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
                    ->modalHeading('Input Pemeriksaan Tekanan Darah')
                    ->mutateFormDataUsing(function (array $data): array {
                        $sistole = $data['sistole'];
                        $diastole = $data['diastole'];
                        if ($sistole < 120 && $diastole < 80) {
                            $data['status'] = "Normal";
                        } elseif ($sistole >= 120 || $diastole >= 80) {
                            $data['status'] = "Tinggi";
                        } else {
                            $data['status'] = "";
                        }
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Tekanan Darah')
                            ->where('status', $data['status'])
                            ->first();
                        $data['rekomendasi_id'] = $rekomendasi->id;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Pemeriksaan Tekanan Darah')
                    ->mutateFormDataUsing(function (array $data): array {
                        $sistole = $data['sistole'];
                        $diastole = $data['diastole'];
                        if ($sistole < 120 && $diastole < 80) {
                            $data['status'] = "Normal";
                        } elseif ($sistole >= 120 || $diastole >= 80) {
                            $data['status'] = "Tinggi";
                        } else {
                            $data['status'] = "";
                        }
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Tekanan Darah')
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
