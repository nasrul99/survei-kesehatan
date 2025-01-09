<?php

namespace App\Filament\Resources\RekomendasiResource\Pages;

use App\Filament\Resources\RekomendasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekomendasis extends ListRecords
{
    protected static string $resource = RekomendasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
