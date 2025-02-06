<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fisik extends Model
{
    use HasFactory;

    protected $table = 'fisik';
    protected $fillable = ['tanggal', 'masyarakat_id', 'berat_badan', 'tinggi_badan', 'imt', 'kondisi_fisik'];

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

}
