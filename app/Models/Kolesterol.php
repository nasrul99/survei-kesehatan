<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kolesterol extends Model
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

    protected $table = 'kolesterol';
    protected $fillable = ['tanggal', 'masyarakat_id', 'hasil', 'status', 'rekomendasi_id'];

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function getPemeriksaanAttribute()
    {
        return 'Kolesterol'; // Mengembalikan nama pemeriksaan
    }

    public static function setStatusFromValue($hasil)
    {
        return $hasil <= 200 ? self::NORMAL : self::TINGGI;
    }

    public static function setRekomendasiFromValue($status)
    {
        $rekomendasi = Rekomendasi::where('nama_pemeriksaan', 'Kolesterol')
            ->where('status', $status)
            ->first();

        return $rekomendasi ? $rekomendasi->id : null;
    }

}
