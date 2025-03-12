<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualan = [];
        for ($i = 1; $i <= 10; $i++) {
            $penjualan[] = [
                'penjualan_id' => $i,
                'user_id' => rand(1, 3),
                'pembeli' => 'Pembeli ' . chr(64 + $i),
                'penjualan_kode' => 'PJ' . $i,
                'penjualan_tanggal' => now(),
            ];
        }
        DB::table('t_penjualan')->insert($penjualan);
    }
}
