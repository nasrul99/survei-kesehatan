<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = ['nama', 'gender', 'tempat_lahir', 'tanggal_lahir', 'umur', 'divisi_id', 'user_id', 'foto'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

    public function fisik(): HasMany
    {
        return $this->hasMany(Fisik::class);
    }

    public function asam_urat(): HasMany
    {
        return $this->hasMany(AsamUrat::class);
    }

    public function kolesterol(): HasMany
    {
        return $this->hasMany(Kolesterol::class);
    }

    public function gula_darah(): HasMany
    {
        return $this->hasMany(GulaDarah::class);
    }

    public function tekanan_darah(): HasMany
    {
        return $this->hasMany(TekananDarah::class);
    }

    // Di model Pegawai.php
    public function latestFisik()
    {
        return $this->hasOne(Fisik::class)->latestOfMany(); // Mengambil data fisik terbaru
    }

}
