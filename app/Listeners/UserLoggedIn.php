<?php

namespace App\Listeners;

use App\Models\Masyarakat;
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
        if (!$user->hasAnyRole(['Super Admin', 'Masyarakat'])) {
            $user->assignRole('Masyarakat');
        }

        //cek data masyarakat
        if ($user->hasRole('Masyarakat')) {
            $masyarakat = Masyarakat::with('user')->where('user_id', $user->id)->first();
            if (!$masyarakat) {
                $masyarakat = new Masyarakat();
                $masyarakat->nama = $user->name;
                $masyarakat->user_id = $user->id;
                $masyarakat->save();
            }
        }

    }
}
