<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::create([
            'nama_obat' => 'Paracetamol 500mg',
            'kemasan' => 'Strip',
            'harga' => 5000,
            'expired' => '2027-12-31',
            'golongan_obat' => 'Bebas',
            'distributor' => 'PT Kimia Farma Trading',
            'produsen_obat' => 'PT Kimia Farma',
            'stok' => 50,
        ]);

        Obat::create([
            'nama_obat' => 'Amoxicillin 500mg',
            'kemasan' => 'Botol',
            'harga' => 12000,
            'expired' => '2028-06-30',
            'golongan_obat' => 'Keras',
            'distributor' => 'PT Dexa Medica Trading',
            'produsen_obat' => 'PT Dexa Medica',
            'stok' => 8,
        ]);

        Obat::create([
            'nama_obat' => 'Vitamin C IPI',
            'kemasan' => 'Botol',
            'harga' => 8000,
            'expired' => '2026-10-15',
            'golongan_obat' => 'Bebas',
            'distributor' => 'PT Tempo Scan Pacific',
            'produsen_obat' => 'PT Supra Ferbindo Farma',
            'stok' => 0,
        ]);
        // Generate additional dummy data for pagination test
        Obat::factory()->count(25)->create();
    }
}
