<?php

namespace App\Filament\Masyarakat\Resources\AsamUratResource\Pages;

use App\Filament\Masyarakat\Resources\AsamUratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsamUrats extends ListRecords
{
    protected static string $resource = AsamUratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
