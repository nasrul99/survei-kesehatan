<?php

namespace App\Filament\Masyarakat\Widgets;

use App\Models\Masyarakat;
use App\Models\TekananDarah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PemeriksaanTekananDarahChart extends ChartWidget
{
    protected static ?int $sort = 5;
    protected static ?string $heading = 'Grafik Pemeriksaan Tekanan Darah';

    protected function getData(): array
    {
        // Mendapatkan masyarakat yang sedang login
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        // Mengambil data pemeriksaan tekanan darah untuk masyarakat yang sedang login
        $data = TekananDarah::select('tekanan_darah.sistole', 'tekanan_darah.diastole', 'tekanan_darah.status', 'tekanan_darah.tanggal')
            ->where('tekanan_darah.masyarakat_id', $masyarakat->id)
            ->orderBy('tekanan_darah.tanggal')
            ->get();

        // Memetakan data untuk grafik
        $labels = $data->pluck('tanggal')->map(function ($tanggal) {
            return $tanggal;
        }); // X-axis: tahun (diambil dari tanggal)

        $sistoleResults = $data->pluck('sistole'); // Y-axis: hasil untuk sistole
        $diastoleResults = $data->pluck('diastole'); // Y-axis: hasil untuk diastole
        $statuses = $data->pluck('status'); // Tooltip: status

        // Mengatur warna berdasarkan status untuk sistole
        $sistoleBackgroundColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 0, 0, 0.2)' :
                ($status === 'Normal' ? 'rgba(0, 180, 0, 0.2)' : // Variasi warna normal
                    'rgba(255, 165, 0, 0.2)'); // Rendah
        });

        $sistoleBorderColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 0, 0, 1)' :
                ($status === 'Normal' ? 'rgba(0, 180, 0, 1)' : // Variasi warna normal
                    'rgba(255, 165, 0, 1)'); // Rendah
        });

        // Mengatur warna berdasarkan status untuk diastole
        $diastoleBackgroundColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 128, 128, 0.2)' : // Variasi warna untuk Tinggi
                ($status === 'Normal' ? 'rgba(0, 255, 0, 0.2)' : // Variasi warna normal
                    'rgba(255, 215, 0, 0.2)'); // Rendah
        });

        $diastoleBorderColors = $statuses->map(function ($status) {
            return $status === 'Tinggi' ? 'rgba(255, 128, 128, 1)' : // Variasi warna untuk Tinggi
                ($status === 'Normal' ? 'rgba(0, 255, 0, 1)' : // Variasi warna normal
                    'rgba(255, 215, 0, 1)'); // Rendah
        });

        return [
            'datasets' => [
                [
                    'label' => 'Sistole',
                    'data' => $sistoleResults,
                    'backgroundColor' => $sistoleBackgroundColors, // Warna berdasarkan status
                    'borderColor' => $sistoleBorderColors, // Warna border berdasarkan status
                    'borderWidth' => 2,
                    'fill' => false, // Line chart tidak menggunakan fill
                    'tension' => 0.1, // Untuk kelenturan garis
                ],
                [
                    'label' => 'Diastole',
                    'data' => $diastoleResults,
                    'backgroundColor' => $diastoleBackgroundColors, // Warna berdasarkan status
                    'borderColor' => $diastoleBorderColors, // Warna border berdasarkan status
                    'borderWidth' => 2,
                    'fill' => false, // Line chart tidak menggunakan fill
                    'tension' => 0.1, // Untuk kelenturan garis
                ],
            ],
            'labels' => $labels, // X-axis: tahun
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik bar
    }
}
