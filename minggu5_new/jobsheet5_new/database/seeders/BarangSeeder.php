<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Laptop Asus Tuf',
                'harga_beli' => 10000000,
                'harga_jual' => 15000000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Mouse Sades',
                'harga_beli' => 200000,
                'harga_jual' => 250000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Kaos Polos Hitam',
                'harga_beli' => 50000,
                'harga_jual' => 75000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Jaket Hoodie Blackpink',
                'harga_beli' => 150000,
                'harga_jual' => 200000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Mie Sarimi',
                'harga_beli' => 2500,
                'harga_jual' => 3000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Beras Sendang Biru',
                'harga_beli' => 60000,
                'harga_jual' => 70000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Meja Gaming Fantech',
                'harga_beli' => 350000,
                'harga_jual' => 400000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Kursi Gaming Vortexseries',
                'harga_beli' => 5000000,
                'harga_jual' => 5500000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Vitamin A',
                'harga_beli' => 30000,
                'harga_jual' => 40000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Paracetamol',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
