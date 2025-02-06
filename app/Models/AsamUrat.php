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
    protected $fillable = ['tanggal', 'masyarakat_id', 'hasil', 'status', 'rekomendasi_id'];

    public function getPemeriksaanAttribute()
    {
        return 'Asam Urat'; // Mengembalikan nama pemeriksaan
    }

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function setStatus()
    {
        // Pastikan masyarakat tidak null sebelum mengakses gender
        if (!$this->masyarakat) {
            throw new \Exception("Data masyarakat tidak ditemukan");
        }

        $gender = $this->masyarakat->gender; // Ambil gender dari tabel masyarakat
        $hasil = $this->hasil; // Ambil hasil dari form

        if ($gender == 'L') { // Jika laki-laki
            if ($hasil < 3.4) $this->status = self::RENDAH;
            else if ($hasil >= 3.4 && $hasil <= 7.0) $this->status = self::NORMAL;
            else $this->status = self::TINGGI;
        } else { // Jika perempuan
            if ($hasil < 2.4) $this->status = self::RENDAH;
            else if ($hasil >= 2.4 && $hasil <= 6.0) $this->status = self::NORMAL;
            else $this->status = self::TINGGI;
        }

        return $this->status; // Kembalikan status agar bisa digunakan di tempat lain
    }

    public function setRekomendasi()
    {
        if (!$this->status) {
            throw new \Exception("Status belum ditentukan, tidak bisa mencari rekomendasi.");
        }

        $rekomendasi = Rekomendasi::query()
            ->where('nama_pemeriksaan', 'Asam Urat')
            ->where('status', $this->status)
            ->first();

        // Jika tidak ada rekomendasi yang cocok, beri nilai default (null atau id tertentu)
        $this->rekomendasi_id = $rekomendasi ? $rekomendasi->id : null;

        return $this->rekomendasi_id; // Kembalikan ID rekomendasi agar bisa digunakan di tempat lain
    }


}
