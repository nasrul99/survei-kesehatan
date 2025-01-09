<?php

namespace App\Filament\Widgets;

use App\Models\Pegawai;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PegawaiTable extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 'full';


    protected function getTableQuery(): Builder
    {
        // Mengembalikan query builder Eloquent
        return Pegawai::query();
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->query(
                Pegawai::query()
            )
            ->heading('Data Hasil Pemeriksaan Kesehatan Pegawai Terkini')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('divisi.nama')
                    ->label('Divisi')
                    ->sortable()
                    ->searchable(),
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
                    ->getStateUsing(fn($record) => $record->fisik()->latest('periode_id')->first()?->kondisi_fisik
                    )
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('asam_urat.hasil')
                    ->label('Asam Urat')
                    ->getStateUsing(fn($record) => $record->asam_urat()->latest('periode_id')->first()?->hasil
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('asam_urat.status')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->asam_urat()->latest('periode_id')->first()?->status
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kolesterol.hasil')
                    ->label('Kolesterol Total')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kolesterol.status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gula_darah.hasil')
                    ->label('Gula Darah')
                    ->getStateUsing(fn($record) => $record->gula_darah()->latest('periode_id')->first()?->hasil
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('gula_darah.status')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->gula_darah()->latest('periode_id')->first()?->status
                    )
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kolesterol.hasil')
                    ->label('Kolesterol')
                    ->getStateUsing(fn($record) => $record->kolesterol()->latest('periode_id')->first()?->hasil
                    )
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kolesterol.status')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->kolesterol()->latest('periode_id')->first()?->status
                    )
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('tekanan_darah.sistole')
                    ->label('Tekanan Darah')
                    ->getStateUsing(function ($record) {
                        $tekanan_darah = $record->tekanan_darah()->latest('periode_id')->first();
                        if ($tekanan_darah && $tekanan_darah->sistole && $tekanan_darah->diastole) {
                            return $tekanan_darah->sistole . '/' . $tekanan_darah->diastole;
                        }
                        return null; // Jika salah satu tidak ada, kembalikan null (kosong)
                    })
                    ->sortable()
                    ->searchable(),


                Tables\Columns\TextColumn::make('tekanan_darah.status')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->tekanan_darah()->latest('periode_id')->first()?->status
                    )
                    ->sortable()
                    ->searchable(),


            ]);
    }
}
