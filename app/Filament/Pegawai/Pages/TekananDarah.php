<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\TekananDarah as BaseTekananDarah;
use Filament\Pages\Page;
use App\Models\Pegawai;
use Filament\Tables;
use Filament\Tables\Table;

class TekananDarah extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $pluralLabel = 'Tekanan Darah';


    protected static ?string $navigationGroup = 'Pemeriksaan';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pegawai.pages.tekanan-darah';

    public function table(Table $table): Table
    {
        // Mendapatkan pegawai yang sedang login
        $pegawai = Pegawai::with('user')->where('user_id', auth()->id())->firstOrFail();

        return $table
            // Mengambil data asam urat untuk pegawai yang sedang login
            ->query(BaseTekananDarah::query()->where('pegawai_id', $pegawai->id))
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('periode.tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sistole')
                    ->label('Hasil')
                    ->getStateUsing(function ($record) {
                        // Pastikan sistole dan diastole diakses dari $record
                        return $record->sistole . '/' . $record->diastole; // Menggabungkan sistole dan diastole
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->label('Rekomendasi')
                    ->html()
                    ->sortable(),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }


}
