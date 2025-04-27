<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_kode'  => 'SUP001',
                'supplier_nama'  => 'PT Maju Jaya',
                'supplier_alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_kode'  => 'SUP002',
                'supplier_nama'  => 'CV Sukses Abadi',
                'supplier_alamat' => 'Jl. Sudirman No. 20, Bandung',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'supplier_kode'  => 'SUP003',
                'supplier_nama'  => 'UD Sumber Makmur',
                'supplier_alamat' => 'Jl. Diponegoro No. 5, Surabaya',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        
        ];
    }
}
