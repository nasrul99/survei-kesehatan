<?php

namespace App\Filament\Masyarakat\Resources\KolesterolResource\Pages;

use App\Filament\Masyarakat\Resources\KolesterolResource;
use App\Models\Kolesterol;
use App\Models\Masyarakat;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKolesterol extends EditRecord
{
    protected static string $resource = KolesterolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $masyarakat = Masyarakat::where('user_id', auth()->id())->first();
        if (!$masyarakat) {
            throw new \Exception("Masyarakat tidak ditemukan untuk user ID: " . auth()->id());
        }

        $data['masyarakat_id'] = $masyarakat->id;
        $data['tanggal'] = $data['tanggal'] ?? now()->format('Y-m-d');

        // Gunakan metode statis untuk menetapkan status dan rekomendasi
        $data['status'] = Kolesterol::setStatusFromValue($data['hasil']);
        $data['rekomendasi_id'] = Kolesterol::setRekomendasiFromValue($data['status']);

        return $data;
    }

}
