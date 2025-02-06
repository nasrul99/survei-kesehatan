<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class TekananDarah extends Model
{
    use HasFactory;

    const STATUS = [
        'Normal',
        'Pra-hipertensi',
        'Hipertensi Tingkat 1',
        'Hipertensi Tingkat 2',
        'Hipertensi Sistolik Terisolasi'
    ];


    protected $table = 'tekanan_darah';
    protected $fillable = ['tanggal', 'masyarakat_id', 'sistole', 'diastole', 'status', 'rekomendasi_id'];

    public function getPemeriksaanAttribute()
    {
        return 'Tekanan Darah'; // Mengembalikan nama pemeriksaan
    }

    public function masyarakat(): BelongsTo
    {
        return $this->belongsTo(Masyarakat::class);
    }

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    public function rules()
    {
        return [
            'status' => ['required', Rule::in(TekananDarah::STATUS)],
        ];
    }


    public static function setStatusFromValue($sistole, $diastole)
    {
        if ($sistole < 120 && $diastole < 80) {
            return 'Normal';
        } elseif (($sistole >= 120 && $sistole <= 139) || ($diastole >= 80 && $diastole <= 89)) {
            return 'Pra-hipertensi';
        } elseif (($sistole >= 140 && $sistole <= 159) || ($diastole >= 90 && $diastole <= 99)) {
            return 'Hipertensi Tingkat 1';
        } elseif ($sistole >= 160 || $diastole >= 100) {
            return 'Hipertensi Tingkat 2';
        } elseif ($sistole > 140 && $diastole < 90) {
            return 'Hipertensi Sistolik Terisolasi';
        }
        return null;
    }


    public static function setRekomendasiFromValue($status)
    {
        $rekomendasi = Rekomendasi::where('nama_pemeriksaan', 'Tekanan Darah')
            ->where('status', $status)
            ->first();

        return $rekomendasi ? $rekomendasi->id : null;
    }
}
