<?php

namespace App\Filament\Masyarakat\Widgets;

use App\Models\Masyarakat;
use App\Models\AsamUrat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PemeriksaanAsamUratChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Grafik Pemeriksaan Asam Urat';

    protected function getData(): array
    {
        // Mendapatkan masyarakat yang sedang login
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        // Mengambil data pemeriksaan asam urat untuk masyarakat yang sedang login
        $data = AsamUrat::select('asam_urat.hasil', 'asam_urat.status', 'asam_urat.tanggal')
            ->where('asam_urat.masyarakat_id', $masyarakat->id)
            ->orderBy('asam_urat.tanggal', 'asc')
            ->get();

        // Memetakan data untuk grafik
        $labels = $data->pluck('tanggal')->map(function ($tanggal) {
            return date('d-m-Y', strtotime($tanggal));
        }); // X-axis: tanggal pemeriksaan
        $statuses = $data->pluck('status'); // Tooltip: status
        $results = $data->pluck('hasil'); // Y-axis: hasil

        // Mengatur warna berdasarkan status
        $backgroundColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 0, 0, 0.2)' :
                ($status === 'Normal' ? 'rgba(0, 128, 0, 0.2)' :
                    'rgba(255, 165, 0, 0.2)');
        });

        $borderColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 0, 0, 1)' :
                ($status === 'Normal' ? 'rgba(0, 128, 0, 1)' :
                    'rgba(255, 165, 0, 1)');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Hasil Pemeriksaan',
                    'data' => $results,
                    'backgroundColor' => $backgroundColors, // Warna berdasarkan status
                    'borderColor' => $borderColors, // Warna border berdasarkan status
                    'borderWidth' => 2,
                    'fill' => false, // Line chart tidak menggunakan fill
                    'tension' => 0.1, // Untuk kelenturan garis
                ],
            ],
            'labels' => $labels, // X-axis: tanggal pemeriksaan
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
