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

    const PUASA = 'Puasa';
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

    protected $fillable = ['tanggal', 'masyarakat_id', 'jenis', 'hasil', 'status', 'rekomendasi_id'];

    public function getPemeriksaanAttribute()
    {
        return 'Gula Darah'; // Mengembalikan nama pemeriksaan
    }

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    /**
     * Menentukan status berdasarkan hasil pemeriksaan gula darah.
     *
     * @param string $jenis Jenis pemeriksaan (Puasa, Sewaktu, Post Prandial)
     * @param int $hasil Nilai hasil pemeriksaan gula darah
     * @return string Status (Rendah, Normal, Tinggi)
     */
    public static function setStatusFromValue($jenis, $hasil)
    {
        if ($hasil < 70) {
            return self::RENDAH;
        }

        if (
            ($jenis === self::PUASA && ($hasil >= 70 && $hasil <= 100)) ||
            ($jenis === self::SEWAKTU && ($hasil >= 70 && $hasil <= 125)) ||
            ($jenis === self::POST_PRANDIAL && $hasil < 140)
        ) {
            return self::NORMAL;
        }

        return self::TINGGI;
    }

    /**
     * Mengambil rekomendasi berdasarkan status pemeriksaan gula darah.
     *
     * @param string $status Status pemeriksaan gula darah
     * @return int|null ID rekomendasi atau null jika tidak ditemukan
     */
    public static function setRekomendasiFromValue($status)
    {
        $rekomendasi = Rekomendasi::where('nama_pemeriksaan', 'Gula Darah')
            ->where('status', $status)
            ->first();

        return $rekomendasi?->id;
    }
}
