<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'pembeli' => 'Santoso',
                'penjualan_kode' => 'TRX001',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Iqbal',
                'penjualan_kode' => 'TRX002',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Iwan',
                'penjualan_kode' => 'TRX003',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Dian',
                'penjualan_kode' => 'TRX004',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Eka Putri',
                'penjualan_kode' => 'TRX005',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Fajar',
                'penjualan_kode' => 'TRX006',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Michelle',
                'penjualan_kode' => 'TRX007',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Hadi',
                'penjualan_kode' => 'TRX008',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Jono',
                'penjualan_kode' => 'TRX009',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Sasmito',
                'penjualan_kode' => 'TRX010',
                'penjualan_tanggal' => now(),
            ],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
