<?php

namespace App\Filament\Pegawai\Widgets;

use App\Models\Pegawai;
use App\Models\TekananDarah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PemeriksaanTekananDarahChart extends ChartWidget
{
    protected static ?int $sort = 5;
    protected static ?string $heading = 'Grafik Pemeriksaan Tekanan Darah';

    protected function getData(): array
    {
// Mendapatkan pegawai yang sedang login
        $pegawai = Pegawai::with('user')->where('user_id', auth()->id())->firstOrFail();

// Mengambil data pemeriksaan tekanan darah untuk pegawai yang sedang login
        $data = TekananDarah::select('periode.tahun', 'tekanan_darah.sistole', 'tekanan_darah.diastole', 'tekanan_darah.status')
            ->join('periode', 'periode.id', '=', 'tekanan_darah.periode_id')
            ->where('tekanan_darah.pegawai_id', $pegawai->id)
            ->orderBy('periode.tahun')
            ->get();

// Memetakan data untuk grafik
        $labels = $data->pluck('tahun'); // X-axis: tahun
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
        return 'bar'; // Tipe grafik bar
    }
}
