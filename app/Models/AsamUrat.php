<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsamUrat extends Model
{
    use HasFactory;

    public string $nama = 'Asam Urat';

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
    protected $table = 'asam_urat';
    protected $fillable = ['periode_id', 'tanggal', 'pegawai_id', 'hasil', 'status', 'rekomendasi_id'];

    public function getPemeriksaanAttribute()
    {
        return 'Asam Urat'; // Mengembalikan nama pemeriksaan
    }
    
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
