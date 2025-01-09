<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fisik extends Model
{
    use HasFactory;

    protected $table = 'fisik';
    protected $fillable = ['periode_id', 'tanggal', 'pegawai_id', 'berat_badan', 'tinggi_badan', 'imt', 'kondisi_fisik'];

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
