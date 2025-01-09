<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\Kolesterol as BaseKolesterol;
use Filament\Pages\Page;
use App\Models\Pegawai;
use Filament\Tables;
use Filament\Tables\Table;


class Kolesterol extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $pluralLabel = 'Kolesterol';


    protected static ?string $navigationGroup = 'Pemeriksaan';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pegawai.pages.kolesterol';

    public function table(Table $table): Table
    {
        // Mendapatkan pegawai yang sedang login
        $pegawai = Pegawai::with('user')->where('user_id', auth()->id())->firstOrFail();

        return $table
            // Mengambil data asam urat untuk pegawai yang sedang login
            ->query(BaseKolesterol::query()->where('pegawai_id', $pegawai->id))
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('periode.tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hasil')
                    ->label('Hasil')
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
