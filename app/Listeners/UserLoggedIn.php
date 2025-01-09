<?php

namespace App\Listeners;

use App\Models\Masyarakat;
use App\Models\Pegawai;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class UserLoggedIn
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        if(!$user->hasAnyRole(['Super Admin','Pegawai'])){
            $user->assignRole('Pegawai');
        }

        //cek data masyarakat
        if($user->hasRole('Pegawai')){
            $pegawai = Pegawai::with('user')->where('user_id', $user->id)->first();
            if(!$pegawai){
                $pegawai = new Pegawai();
                $pegawai->nama = $user->name;
                $pegawai->user_id = $user->id;
                $pegawai->save();
            }
        }

    }
}
