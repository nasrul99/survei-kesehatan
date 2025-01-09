<?php

namespace Database\Seeders;

use App\Models\Rekomendasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekomendasi::create([
            'nama_pemeriksaan' => 'Asam Urat',
            'status' => 'Rendah',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan asam urat rendah adalah ... ',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Asam Urat',
            'status' => 'Normal',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan asam urat normal adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Asam Urat',
            'status' => 'Tinggi',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan asam urat tinggi adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Kolesterol',
            'status' => 'Rendah',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan kolesterol rendah adalah ... ',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Kolesterol',
            'status' => 'Normal',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan kolesterol normal adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Kolesterol',
            'status' => 'Tinggi',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan kolesterol tinggi adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Tekanan Darah',
            'status' => 'Rendah',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan tekanan darah rendah adalah ... ',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Tekanan Darah',
            'status' => 'Normal',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan tekanan darah normal adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Tekanan Darah',
            'status' => 'Tinggi',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan tekanan darah tinggi adalah ...',
        ]);
        Rekomendasi::create([
            'nama_pemeriksaan' => 'Gula Darah',
            'status' => 'Rendah',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan gula darah rendah adalah ... ',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Gula Darah',
            'status' => 'Normal',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan gula darah normal adalah ...',
        ]);

        Rekomendasi::create([
            'nama_pemeriksaan' => 'Gula Darah',
            'status' => 'Tinggi',
            'rekomendasi_status' => 'Rekomendasi untuk hasil pemeriksaan gula darah tinggi adalah ...',
        ]);


    }
}
