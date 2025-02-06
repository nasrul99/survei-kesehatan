<?php

namespace App\Filament\Masyarakat\Resources\FisikResource\Pages;

use App\Filament\Masyarakat\Resources\FisikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFisiks extends ListRecords
{
    protected static string $resource = FisikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
