<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rekomendasi extends Model
{
    use HasFactory;

    const RENDAH = 'Rendah';
    const NORMAL = 'Normal';
    const TINGGI = 'Tinggi';
    const PRA_HIPERTENSI = 'Pra-hipertensi';
    const HT1 = 'Hipertensi Tingkat 1';
    const HT2 = 'Hipertensi Tingkat 2';
    const HST = 'Hipertensi Sistolik Terisolasi';
    const LABELS = [
        self::RENDAH => 'Rendah',
        self::NORMAL => 'Normal',
        self::TINGGI => 'Tinggi',
        self::PRA_HIPERTENSI => 'Pra-hipertensi',
        self::HT1 => 'Hipertensi Tingkat 1',
        self::HT2 => 'Hipertensi Tingkat 2',
        self::HST => 'Hipertensi Sistolik Terisolasi',
    ];
    const COLORS = [
        self::RENDAH => 'warning',
        self::NORMAL => 'success',
        self::TINGGI => 'danger',
        self::PRA_HIPERTENSI => 'danger',
        self::HT1 => 'danger',
        self::HT2 => 'danger',
        self::HST => 'danger',
    ];
    const ICONS = [
        self::RENDAH => 'heroicon-m-arrow-down-circle',
        self::NORMAL => 'heroicon-m-check-circle',
        self::TINGGI => 'heroicon-m-arrow-up-circle',
        self::PRA_HIPERTENSI => 'heroicon-m-arrow-up-circle',
        self::HT1 => 'heroicon-m-arrow-up-circle',
        self::HT2 => 'heroicon-m-arrow-up-circle',
        self::HST => 'heroicon-m-arrow-up-circle',
    ];

    protected $table = 'rekomendasi';
    protected $fillable = ['nama_pemeriksaan', 'status', 'rekomendasi_status'];

    public function kolesterol(): HasMany
    {
        return $this->hasMany(Kolesterol::class);
    }

    public function asam_urat(): HasMany
    {
        return $this->hasMany(AsamUrat::class);
    }

    public function gula_darah(): HasMany
    {
        return $this->hasMany(GulaDarah::class);
    }


}
