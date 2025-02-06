<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class AsamUratChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;
    //protected int|string|array $columnSpan = 'full'

    protected static ?string $heading = 'Persentase Grafik Pemeriksaan Asam Urat Masyarakat';

    protected function getData(): array
    {
        // Ganti ini dengan periode_id yang ingin Anda filter
        //$periodeId = 1;
        //$periodeId = $this->filters['periode_id'];

        // Dapatkan total pemeriksaan untuk periode_id tertentu
        $total = DB::table('asam_urat')
            //->where('periode_id', $periodeId)
            ->count();

        // Dapatkan jumlah pemeriksaan berdasarkan status (Rendah, Normal, Tinggi)
        $data = DB::table('asam_urat')
            ->select('status', DB::raw('COUNT(*) as count'))
            //->where('periode_id', $periodeId)
            ->groupBy('status')
            ->get();

        // Inisialisasi array untuk menyimpan data persentase
        $statusCounts = [
            'Rendah' => 0,
            'Normal' => 0,
            'Tinggi' => 0,
        ];

        // Isi data dengan hasil query
        foreach ($data as $item) {
            $statusCounts[$item->status] = ($item->count / $total) * 100; // Hitung persentase
        }

        return [
            'datasets' => [
                [
                    'label' => 'Persentase Pemeriksaan Asam Urat',
                    'data' => [
                        $statusCounts['Rendah'],
                        $statusCounts['Normal'],
                        $statusCounts['Tinggi'],
                    ],  // Persentase untuk Rendah, Normal, Tinggi
                    'backgroundColor' => [
                        'rgba(255, 165, 0, 0.2)',   // Oranye untuk Rendah
                        'rgba(0, 128, 0, 0.2)',     // Hijau untuk Normal
                        'rgba(255, 0, 0, 0.2)',     // Merah untuk Tinggi
                    ],
                    'borderColor' => [
                        'rgba(255, 165, 0, 1)',   // Oranye untuk Rendah
                        'rgba(0, 128, 0, 1)',     // Hijau untuk Normal
                        'rgba(255, 0, 0, 1)',     // Merah untuk Tinggi
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Rendah', 'Normal', 'Tinggi'],  // Label untuk hasil pemeriksaan Asam Urat
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
