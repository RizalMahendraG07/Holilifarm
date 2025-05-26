<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('riwayats')->insert([
            [   'nama_pembeli' => 'Ipang',
                'alamat' => 'Rowo Indah, RT 16 , RW 06',
                'produk_id' => '2',
                'jumlah_produk'=> '3',
                'harga_total'=> '21000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
            
        ]);
    }
}
