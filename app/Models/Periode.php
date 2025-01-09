<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $fillable = ['nama', 'tahun'];

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


}
