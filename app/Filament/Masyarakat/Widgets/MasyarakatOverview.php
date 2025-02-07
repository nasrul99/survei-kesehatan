<?php

namespace App\Filament\Masyarakat\Widgets;

use App\Models\Masyarakat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class MasyarakatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Mengambil data masyarakat yang terhubung dengan user yang sedang login
        $peg = Masyarakat::with([
            'asam_urat' => function ($query) {
                $query->latest('tanggal');
            },
            'kolesterol' => function ($query) {
                $query->latest('tanggal');
            },
            'tekanan_darah' => function ($query) {
                $query->latest('tanggal');
            },
            'gula_darah' => function ($query) {
                $query->latest('tanggal');
            },
            'fisik' => function ($query) {
                $query->latest('tanggal'); // Mengambil data berdasarkan tanggal terakhir
            }
        ])->where('user_id', auth()->id())->firstOrFail();

        // Menghitung umur masyarakat
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
                ->description('Kondisi Fisik Masyarakat')
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
