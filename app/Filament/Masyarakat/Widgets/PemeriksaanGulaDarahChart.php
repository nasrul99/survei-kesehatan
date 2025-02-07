<?php

namespace App\Filament\Masyarakat\Widgets;

use App\Models\Masyarakat;
use App\Models\GulaDarah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PemeriksaanGulaDarahChart extends ChartWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Grafik Pemeriksaan Gula Darah';

    protected function getData(): array
    {
        // Mendapatkan masyarakat yang sedang login
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        // Mengambil data pemeriksaan gula darah untuk masyarakat yang sedang login
        $data = GulaDarah::select('gula_darah.tanggal', 'gula_darah.hasil', 'gula_darah.status')
            ->where('gula_darah.masyarakat_id', $masyarakat->id)
            ->orderBy('gula_darah.tanggal')
            ->get();

        // Memetakan data untuk grafik
        $labels = $data->pluck('tanggal')->map(function ($date) {
            return date('d-m-Y', strtotime($date));
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
