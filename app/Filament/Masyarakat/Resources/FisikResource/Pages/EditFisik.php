<?php

namespace App\Filament\Masyarakat\Resources\FisikResource\Pages;

use App\Filament\Masyarakat\Resources\FisikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFisik extends EditRecord
{
    protected static string $resource = FisikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
