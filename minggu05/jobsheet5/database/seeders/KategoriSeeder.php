<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['kategori_id' => 1, 'kategori_kode' => 'KAT1', 'kategori_nama' => 'Elektronik'],
            ['kategori_id' => 2, 'kategori_kode' => 'KAT2', 'kategori_nama' => 'Pakaian'],
            ['kategori_id' => 3, 'kategori_kode' => 'KAT3', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 4, 'kategori_kode' => 'KAT4', 'kategori_nama' => 'Perabot'],
            ['kategori_id' => 5, 'kategori_kode' => 'KAT5', 'kategori_nama' => 'Kosmetik'],
        ];
        DB::table('m_kategori')->insert($kategori);
    }
}
