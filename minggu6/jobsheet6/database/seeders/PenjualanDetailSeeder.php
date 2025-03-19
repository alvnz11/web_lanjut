<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualan = DB::table('t_penjualan')->get();
        $penjualan_detail = [];
        foreach ($penjualan as $p) {
            for ($j = 1; $j <= 3; $j++) {
                $penjualan_detail[] = [
                    'detail_id' => ($p->penjualan_id - 1) * 3 + $j,
                    'penjualan_id' => $p->penjualan_id,
                    'barang_id' => rand(1, 10),
                    'harga' => rand(50000, 100000),
                    'jumlah' => rand(1, 5),
                ];
            }
        }
        DB::table('t_penjualan_detail')->insert($penjualan_detail);
    }
}
