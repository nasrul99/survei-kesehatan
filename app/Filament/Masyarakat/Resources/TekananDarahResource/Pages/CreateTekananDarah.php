<?php

namespace App\Filament\Masyarakat\Resources\TekananDarahResource\Pages;

use App\Filament\Masyarakat\Resources\TekananDarahResource;
use App\Models\Masyarakat;
use App\Models\TekananDarah;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTekananDarah extends CreateRecord
{
    protected static string $resource = TekananDarahResource::class;

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

        // Pastikan `sistole` dan `diastole` tersedia di `$data`
        if (!isset($data['sistole']) || !isset($data['diastole'])) {
            throw new \Exception("Data tekanan darah belum lengkap (sistole dan diastole harus diisi).");
        }

        // Set status dan rekomendasi berdasarkan sistole dan diastole
        $data['status'] = TekananDarah::setStatusFromValue($data['sistole'], $data['diastole']);
        $data['rekomendasi_id'] = TekananDarah::setRekomendasiFromValue($data['status']);

        return $data;
    }

}
