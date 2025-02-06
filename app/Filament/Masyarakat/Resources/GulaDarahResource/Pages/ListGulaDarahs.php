<?php

namespace App\Filament\Masyarakat\Resources\GulaDarahResource\Pages;

use App\Filament\Masyarakat\Resources\GulaDarahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGulaDarahs extends ListRecords
{
    protected static string $resource = GulaDarahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
