<?php

namespace App\Filament\Masyarakat\Resources\TekananDarahResource\Pages;

use App\Filament\Masyarakat\Resources\TekananDarahResource;
use App\Models\Masyarakat;
use App\Models\TekananDarah;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTekananDarah extends EditRecord
{
    protected static string $resource = TekananDarahResource::class;

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
        $data['status'] = TekananDarah::setStatusFromValue($data['sistole'], $data['diastole']);
        $data['rekomendasi_id'] = TekananDarah::setRekomendasiFromValue($data['status']);


        return $data;
    }
}
