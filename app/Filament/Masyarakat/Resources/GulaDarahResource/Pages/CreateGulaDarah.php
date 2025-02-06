<?php

namespace App\Filament\Masyarakat\Resources\GulaDarahResource\Pages;

use App\Filament\Masyarakat\Resources\GulaDarahResource;
use App\Models\GulaDarah;
use App\Models\Masyarakat;
use App\Models\TekananDarah;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGulaDarah extends CreateRecord
{
    protected static string $resource = GulaDarahResource::class;

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

        // Pastikan `jenis` dan `hasil` tersedia di `$data`
        if (!isset($data['jenis']) || !isset($data['hasil'])) {
            throw new \Exception("Data gula darah belum lengkap (jenis dan hasil harus diisi).");
        }

        // Set status dan rekomendasi berdasarkan hasil pemeriksaan gula darah
        $data['status'] = GulaDarah::setStatusFromValue($data['jenis'], $data['hasil']);
        $data['rekomendasi_id'] = GulaDarah::setRekomendasiFromValue($data['status']);

        return $data;
    }

}
