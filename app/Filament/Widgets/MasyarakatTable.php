<?php

namespace App\Filament\Widgets;

use App\Models\Masyarakat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MasyarakatTable extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';


    protected function getTableQuery(): Builder
    {
        // Mengembalikan query builder Eloquent
        return Masyarakat::query();
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->query(
                Masyarakat::query()
            )
            ->heading('Data Hasil Pemeriksaan Kesehatan Masyarakat Terkini')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('umur')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                /*
                Tables\Columns\TextColumn::make('fisik.tinggi_badan')
                    ->label('Tinggi Badan')
                    ->getStateUsing(fn($record) => $record->fisik()->latest('periode_id')->first()?->tinggi_badan
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fisik.imt')
                    ->label('IMT')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        $fisik = $record->fisik()->latest('periode_id')->first();
                        return $fisik ? number_format($fisik->imt, 2) : null;
                    }),
                  */
                Tables\Columns\TextColumn::make('fisik.kondisi_fisik')
                    ->label('Kondisi Fisik')
                    ->getStateUsing(function ($record) {
                        $fisikTerakhir = $record->fisik()->latest('created_at')->first(); // Menggunakan created_at sebagai alternatif
                        return $fisikTerakhir ? $fisikTerakhir->kondisi_fisik : '-';
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('asam_urat')
                    ->label('Asam Urat')
                    ->getStateUsing(function ($record) {
                        $asamUrat = $record->asam_urat()->latest('created_at')->first(); // Menggunakan created_at sebagai alternatif
                        return $asamUrat ? $asamUrat->hasil . ' (' . $asamUrat->status . ')' : '-';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('kolesterol')
                    ->label('Kolesterol Total')
                    ->getStateUsing(function ($record) {
                        $kolesterol = $record->kolesterol()->latest('created_at')->first(); // Ambil data terbaru berdasarkan created_at
                        return $kolesterol ? $kolesterol->hasil . ' (' . $kolesterol->status . ')' : '-';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('gula_darah')
                    ->label('Gula Darah')
                    ->getStateUsing(function ($record) {
                        $gulaDarah = $record->gula_darah()->latest('created_at')->first(); // Ambil data terbaru berdasarkan created_at
                        return $gulaDarah ? $gulaDarah->hasil . ' (' . $gulaDarah->status . ')' : '-';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('kolesterol')
                    ->label('Kolesterol')
                    ->getStateUsing(function ($record) {
                        $kolesterol = $record->kolesterol()->latest('created_at')->first(); // Ambil data terbaru berdasarkan created_at
                        return $kolesterol ? $kolesterol->hasil . ' (' . $kolesterol->status . ')' : '-';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('tekanan_darah')
                    ->label('Tekanan Darah')
                    ->getStateUsing(function ($record) {
                        $tekanan_darah = $record->tekanan_darah()->latest('created_at')->first(); // Ambil data terbaru
                        if ($tekanan_darah && $tekanan_darah->sistole && $tekanan_darah->diastole) {
                            return "{$tekanan_darah->sistole}/{$tekanan_darah->diastole} ({$tekanan_darah->status})";
                        }
                        return '-'; // Jika tidak ada data
                    })
                    ->sortable(),

            ]);
    }
}
