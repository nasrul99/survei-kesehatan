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
    const LABELS = [
        self::RENDAH => 'Rendah',
        self::NORMAL => 'Normal',
        self::TINGGI => 'Tinggi',
    ];
    const COLORS = [
        self::RENDAH => 'warning',
        self::NORMAL => 'success',
        self::TINGGI => 'danger',
    ];
    const ICONS = [
        self::RENDAH => 'heroicon-m-arrow-down-circle',
        self::NORMAL => 'heroicon-m-check-circle',
        self::TINGGI => 'heroicon-m-arrow-up-circle',
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

    public function tekanan_darah(): HasMany
    {
        return $this->hasMany(TekananDarah::class);
    }

    public function gula_darah(): HasMany
    {
        return $this->hasMany(GulaDarah::class);
    }


}
