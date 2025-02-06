<?php

namespace App\Filament\Masyarakat\Resources\TekananDarahResource\Pages;

use App\Filament\Masyarakat\Resources\TekananDarahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTekananDarahs extends ListRecords
{
    protected static string $resource = TekananDarahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
