<?php

namespace App\Filament\Masyarakat\Resources\KolesterolResource\Pages;

use App\Filament\Masyarakat\Resources\KolesterolResource;
use App\Models\Kolesterol;
use App\Models\Masyarakat;
use Filament\Resources\Pages\CreateRecord;

class CreateKolesterol extends CreateRecord
{
    protected static string $resource = KolesterolResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $masyarakat = Masyarakat::where('user_id', auth()->id())->first();

        if (!$masyarakat) {
            throw new \Exception("Masyarakat tidak ditemukan untuk user ID: " . auth()->id());
        }

        // Set `masyarakat_id`
        $data['masyarakat_id'] = $masyarakat->id;
        $data['tanggal'] = $data['tanggal'] ?? now()->format('Y-m-d');

        // Pastikan `hasil` sudah tersedia di `$data`
        if (!isset($data['hasil'])) {
            throw new \Exception("Hasil kolesterol belum diisi.");
        }

        // Set status dan rekomendasi berdasarkan hasil
        $data['status'] = Kolesterol::setStatusFromValue($data['hasil']);
        $data['rekomendasi_id'] = Kolesterol::setRekomendasiFromValue($data['status']);

        return $data;
    }
}
