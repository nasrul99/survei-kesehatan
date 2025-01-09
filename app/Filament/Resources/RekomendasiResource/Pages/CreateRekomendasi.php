<?php

namespace App\Filament\Resources\RekomendasiResource\Pages;

use App\Filament\Resources\RekomendasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRekomendasi extends CreateRecord
{
    protected static string $resource = RekomendasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
