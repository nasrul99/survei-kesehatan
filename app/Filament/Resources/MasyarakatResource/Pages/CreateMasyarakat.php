<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use App\Models\Masyarakat;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;


class CreateMasyarakat extends CreateRecord
{
    protected static string $resource = MasyarakatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeCreate(): void
    {
        $email = $this->data['user']['email'];
        // Cek apakah email sudah terdaftar
        if (User::where('email', $email)->exists()) {
            Notification::make()
                ->warning()
                ->color('warning')
                ->title('Gagal Menyimpan Masyarakat!')
                ->body('Email sudah terdaftar, silakan gunakan email lain. ')
                ->seconds(10)
                ->send();

            $this->halt();
        }

    }


    protected function handleRecordCreation(array $data): Model
    {
        //dd($data);

        // create user
        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['user']['email'],
            'password' => $data['user']['password'],
        ]);

        $user->assignRole('Masyarakat');
        $user->markEmailAsVerified();

        // set user_id
        $data['user_id'] = $user->id;

        // create satgas
        $masyarakat = MasyarakatResource::getModel()::create($data);

        return $masyarakat;
    }
}
