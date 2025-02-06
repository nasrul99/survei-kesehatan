<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Masyarakat;
use App\Models\Fisik;

// Pastikan untuk mengimpor model Fisik
use App\Models\Periode;

// Pastikan untuk mengimpor model Periode

class PegawaiOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // Ambil periode_id terakhir dari database
        //$periodeId = $this->filters['periode_id'];

        return [
            Stat::make('Total Masyarakat', Masyarakat::count())
                ->description('Masyarakat')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Jumlah Masyarakat', Fisik::where('kondisi_fisik', 'Normal')
                //->where('periode_id', $periodeId) // Filter berdasarkan periode_id terakhir
                ->count())
                ->description('Status Fisik Normal')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('Jumlah Masyarakat', Fisik::where('kondisi_fisik', 'Kurus')
                //->where('periode_id', $periodeId) // Filter berdasarkan periode_id terakhir
                ->count())
                ->description('Status Fisik Kurus')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Jumlah Masyarakat', Fisik::where('kondisi_fisik', 'OverWeight')
                //->where('periode_id', $periodeId) // Filter berdasarkan periode_id terakhir
                ->count())
                ->description('Status Fisik OverWeight')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
            Stat::make('Jumlah Masyarakat', Fisik::where('kondisi_fisik', 'Obesitas 1')
                //->where('periode_id', $periodeId) // Filter berdasarkan periode_id terakhir
                ->count())
                ->description('Status Fisik Obesitas Level 1')
                ->descriptionIcon('heroicon-m-users')
                ->color('danger'),
            Stat::make('Jumlah Masyarakat', Fisik::where('kondisi_fisik', 'Obesitas 2')
                //->where('periode_id', $periodeId) // Filter berdasarkan periode_id terakhir
                ->count())
                ->description('Status Fisik Obesitas Level 2')
                ->descriptionIcon('heroicon-m-users')
                ->color('danger'),
        ];
    }
}
