<?php

namespace App\Filament\Masyarakat\Resources\AsamUratResource\Pages;

use App\Filament\Masyarakat\Resources\AsamUratResource;
use App\Models\Masyarakat;
use App\Models\AsamUrat;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAsamUrat extends CreateRecord
{
    protected static string $resource = AsamUratResource::class;

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

        $data['masyarakat_id'] = $masyarakat->id;

        // Pastikan tanggal diisi (gunakan now() jika tidak ada)
        $data['tanggal'] = $data['tanggal'] ?? now()->format('Y-m-d');

        // Buat instance AsamUrat sementara
        $asamUrat = new AsamUrat();
        $asamUrat->masyarakat()->associate($masyarakat); // Hubungkan dengan masyarakat
        $asamUrat->hasil = $data['hasil']; // Ambil hasil dari form
        $data['status'] = $asamUrat->setStatus(); // Hitung dan simpan status ke $data
        $data['rekomendasi_id'] = $asamUrat->setRekomendasi(); // Hitung dan set rekomendasi
        return $data;
    }

}
