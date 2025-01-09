<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GulaDarah extends Model
{
    use HasFactory;

    const RENDAH = 'Rendah';
    const NORMAL = 'Normal';
    const TINGGI = 'Tinggi';
    const  PUASA = 'Puasa';
    const SEWAKTU = 'Sewaktu';
    const POST_PRANDIAL = 'Post Prandial';
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
    const LBL = [
        self::PUASA => 'Puasa',
        self::SEWAKTU => 'Sewaktu',
        self::POST_PRANDIAL => 'Post Prandial',
    ];

    const WARNA = [
        self::PUASA => 'warning',
        self::SEWAKTU => 'success',
        self::POST_PRANDIAL => 'danger',
    ];
    const IKON = [
        self::PUASA => 'heroicon-m-beaker',
        self::SEWAKTU => 'heroicon-m-bell-alert',
        self::POST_PRANDIAL => 'heroicon-m-cake',
    ];
    protected $table = 'gula_darah';
    protected $fillable = ['periode_id', 'tanggal', 'pegawai_id', 'jenis', 'hasil', 'status', 'rekomendasi_id'];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }
}
