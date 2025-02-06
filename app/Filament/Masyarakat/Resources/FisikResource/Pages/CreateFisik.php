<?php

namespace App\Filament\Masyarakat\Resources\FisikResource\Pages;

use App\Filament\Masyarakat\Resources\FisikResource;
use App\Models\Masyarakat;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFisik extends CreateRecord
{
    protected static string $resource = FisikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $masyarakat = Masyarakat::where('user_id', auth()->id())->first();
        $data['masyarakat_id'] = $masyarakat->id;
        $data['imt'] = $data['berat_badan'] / (pow($data['tinggi_badan'] / 100, 2));
        $imt = $data['imt'];
        if ($imt >= 0 && $imt < 18.5) $kondisi = "Kurus";
        elseif ($imt >= 18.5 && $imt < 25) $kondisi = "Normal";
        elseif ($imt >= 25 && $imt < 30) $kondisi = "OverWeight";
        elseif ($imt >= 30 && $imt < 35) $kondisi = "Obesitas 1";
        elseif ($imt >= 35 && $imt < 40) $kondisi = "Obesitas 2";
        elseif ($imt > 40) $kondisi = "Obesitas 3";
        else $kondisi = "-";
        $data['kondisi_fisik'] = $kondisi;

        return $data;
    }

}
