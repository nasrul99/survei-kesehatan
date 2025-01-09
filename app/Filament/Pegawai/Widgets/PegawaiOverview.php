<?php

namespace App\Filament\Pegawai\Widgets;

use App\Models\Pegawai;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class PegawaiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil data pegawai yang terhubung dengan user yang sedang login
        $peg = Pegawai::with([
            'asam_urat' => function ($query) {
                $query->latest('periode_id');
            },
            'kolesterol' => function ($query) {
                $query->latest('periode_id');
            },
            'tekanan_darah' => function ($query) {
                $query->latest('periode_id');
            },
            'gula_darah' => function ($query) {
                $query->latest('periode_id');
            },
            'fisik' => function ($query) {
                $query->latest('periode_id'); // Mengambil periode_id terakhir dari tabel fisik
            }
        ])->where('user_id', auth()->id())->firstOrFail();

        // Menghitung umur pegawai
        $umur = Carbon::parse($peg->tanggal_lahir)->age;

        // Ambil data dari pemeriksaan terakhir
        $asamUrat = $peg->asam_urat->first();
        $kolesterol = $peg->kolesterol->first();
        $tekananDarah = $peg->tekanan_darah->first();
        $gulaDarah = $peg->gula_darah->first();
        $fisik = $peg->fisik->first(); // Ambil data fisik terakhir

        return [
            Stat::make('Umur Kamu', $umur)
                ->description('Tahun')
                ->descriptionIcon('heroicon-m-user')
                ->color('primary'),

            Stat::make('Kondisi Fisik Kamu', $fisik ? $fisik->kondisi_fisik : 'Data tidak tersedia')
                ->description('Kondisi Fisik Pegawai')
                ->descriptionIcon('heroicon-o-heart')
                ->color('info'),

            Stat::make('Asam Urat Kamu', $asamUrat ? "{$asamUrat->hasil} ({$asamUrat->status})" : 'Data tidak tersedia')
                ->description('Hasil Pemeriksaan (Status)')
                ->descriptionIcon('heroicon-o-beaker')
                ->color($asamUrat && $asamUrat->status === 'Normal' ? 'success' : 'danger'),

            Stat::make('Kolesterol Total Kamu', $kolesterol ? "{$kolesterol->hasil} ({$kolesterol->status})" : 'Data tidak tersedia')
                ->description('Hasil Pemeriksaan (Status)')
                ->descriptionIcon('heroicon-o-beaker')
                ->color($kolesterol && $kolesterol->status === 'Normal' ? 'success' : 'danger'),

            Stat::make('Tekanan Darah Kamu', $tekananDarah ? "{$tekananDarah->sistole} / {$tekananDarah->diastole} ({$tekananDarah->status})" : 'Data tidak tersedia')
                ->description('Hasil Pemeriksaan (Status)')
                ->descriptionIcon('heroicon-o-beaker')
                ->color($tekananDarah && $tekananDarah->status === 'Normal' ? 'success' : 'danger'),

            Stat::make('Gula Darah Kamu', $gulaDarah ? "{$gulaDarah->hasil} ({$gulaDarah->status})" : 'Data tidak tersedia')
                ->description('Hasil Pemeriksaan (Status)')
                ->descriptionIcon('heroicon-o-beaker')
                ->color($gulaDarah && $gulaDarah->status === 'Normal' ? 'success' : 'danger'),
        ];
    }
}
