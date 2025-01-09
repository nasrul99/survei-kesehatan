<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::create([
            'nama' => 'Ketua STT-NF',
        ]);
        Divisi::create([
            'nama' => 'Waket I',
        ]);
        Divisi::create([
            'nama' => 'Waket II',
        ]);
        Divisi::create([
            'nama' => 'Waket III',
        ]);
        Divisi::create([
            'nama' => 'BAAK',
        ]);
        Divisi::create([
            'nama' => 'BKHI',
        ]);
        Divisi::create([
            'nama' => 'LKHI',
        ]);
        Divisi::create([
            'nama' => 'LKKI',
        ]);
        Divisi::create([
            'nama' => 'LPPM',
        ]);
        Divisi::create([
            'nama' => 'LPMI',
        ]);
        Divisi::create([
            'nama' => 'LTSI',
        ]);
        Divisi::create([
            'nama' => 'Marketing NFA',
        ]);
        Divisi::create([
            'nama' => 'Operasional NFA',
        ]);
        Divisi::create([
            'nama' => 'Risbang NFA',
        ]);


    }
}
