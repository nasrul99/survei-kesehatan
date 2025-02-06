<?php

namespace App\Filament\Masyarakat\Pages\Auth;

use App\Models\Masyarakat;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Register extends BaseRegister
{
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        return app(RegistrationResponse::class);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create($data);
        $user->assignRole('Masyarakat');

        $masyarakat = Masyarakat::create([
            'nama' => $data['name'],
            'email' => $data['email'],
            'user_id' => $user->id,
        ]);

        $this->sendEmailVerification($masyarakat, true);

        return $user;
    }

    public function sendEmailVerification(Masyarakat $masyarakat, $toNotify = false): void
    {
        try {
            $masyarakat->user->notify(new VerifyEmailNotification($masyarakat));
            if ($toNotify) {
                Notification::make()
                    ->title(__('Email verifikasi telah dikirim'))
                    ->body(__('Silahkan cek email Anda untuk melanjutkan proses registrasi.'))
                    ->success()
                    ->persistent()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title(__('Gagal mengirim email verifikasi'))
                ->body($e->getMessage())
                ->color('danger')
                ->danger()
                ->persistent()
                ->send();
        }
    }

    public function setValidatedEmail(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->id);

        if (!$this->authorized($request, $user)) {
            Notification::make()
                ->title(__('Verifikasi email gagal'))
                ->body(__('Tautan verifikasi tidak valid.'))
                ->color('danger')
                ->danger()
                ->persistent()
                ->send();
        } else {
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();

                Notification::make()
                    ->title(__('Email berhasil diverifikasi'))
                    ->body(__('Silahkan login untuk melanjutkan.'))
                    ->success()
                    ->persistent()
                    ->send();
            }
        }

        return redirect()->route('filament.masyarakat.auth.login');
    }

    public function authorized(Request $request, User $user): bool
    {
        if (!hash_equals((string)$user->getKey(), (string)$request->id)) {
            return false;
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string)$request->hash)) {
            return false;
        }

        return true;
    }
}
