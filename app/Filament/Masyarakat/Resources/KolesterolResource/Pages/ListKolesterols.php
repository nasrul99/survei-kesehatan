<?php

namespace App\Filament\Masyarakat\Resources\KolesterolResource\Pages;

use App\Filament\Masyarakat\Resources\KolesterolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKolesterols extends ListRecords
{
    protected static string $resource = KolesterolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
