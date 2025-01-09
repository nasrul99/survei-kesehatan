<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $fillable = ['nama', 'divisi_id','gender', 'umur', 'berat_badan', 'tinggi_badan', 'imt', 'user_id','foto'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }

}
