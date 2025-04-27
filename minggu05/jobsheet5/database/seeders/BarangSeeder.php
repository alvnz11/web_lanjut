<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG1', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 7000000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG2', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 5000000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BRG3', 'barang_nama' => 'Jaket Kulit', 'harga_beli' => 200000, 'harga_jual' => 400000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BRG4', 'barang_nama' => 'Kaos Polos', 'harga_beli' => 50000, 'harga_jual' => 100000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BRG5', 'barang_nama' => 'Coklat Premium', 'harga_beli' => 25000, 'harga_jual' => 50000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG6', 'barang_nama' => 'Kopi Arabika', 'harga_beli' => 75000, 'harga_jual' => 150000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BRG7', 'barang_nama' => 'Meja Kayu', 'harga_beli' => 500000, 'harga_jual' => 800000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BRG8', 'barang_nama' => 'Kursi Besi', 'harga_beli' => 300000, 'harga_jual' => 600000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BRG9', 'barang_nama' => 'Lipstik Merah', 'harga_beli' => 100000, 'harga_jual' => 200000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BRG10', 'barang_nama' => 'Parfum Wangi', 'harga_beli' => 250000, 'harga_jual' => 500000],
        ];
        DB::table('m_barang')->insert($barang);
    }
}
