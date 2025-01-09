<?php

namespace App\Filament\Resources\RekomendasiResource\Pages;

use App\Filament\Resources\RekomendasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekomendasi extends EditRecord
{
    protected static string $resource = RekomendasiResource::class;

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
}
