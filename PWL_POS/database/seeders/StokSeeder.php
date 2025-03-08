<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = DB::table('m_barang')->get();
        $stok = [];

        foreach ($barang as $b) {
            $stok[] = [
                'stok_id' => $b->barang_id, // Gunakan -> bukan []
                'barang_id' => $b->barang_id, // Gunakan -> bukan []
                'user_id' => rand(1, 3),
                'stok_tanggal' => now(),
                'stok_jumlah' => rand(10, 100),
            ];
        }

        DB::table('t_stok')->insert($stok);
    }
}
