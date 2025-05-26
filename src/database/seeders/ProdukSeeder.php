<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Melon',
                'price' => 15000,
                'image' => 'storage/fotoproduk/melon.jpg',
                'deskripsi' => 'Melon adalah buah yang kaya akan air dan vitamin C, sangat baik untuk menjaga hidrasi tubuh dan meningkatkan sistem kekebalan. Kandungan antioksidannya juga membantu menjaga kesehatan kulit.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Anggur Hijau',
                'price' => 12000,
                'image' => 'storage/fotoproduk/anggur_hijau.jpg',
                'deskripsi' => 'Anggur hijau mengandung antioksidan tinggi seperti resveratrol yang bermanfaat untuk kesehatan jantung. Selain itu, anggur juga membantu menjaga tekanan darah dan kesehatan pencernaan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brokoli',
                'price' => 8000,
                'image' => 'storage/fotoproduk/brokoli.jpeg',
                'deskripsi' => 'Brokoli merupakan sayuran kaya serat, vitamin C, vitamin K, dan antioksidan. Konsumsi brokoli secara rutin dapat membantu menurunkan risiko kanker, meningkatkan imunitas, dan menjaga kesehatan tulang.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cabai',
                'price' => 25000,
                'image' => 'storage/fotoproduk/cabai.jpg',
                'deskripsi' => 'Cabai mengandung capsaicin yang bermanfaat untuk meningkatkan metabolisme dan membakar kalori. Selain itu, cabai juga kaya akan vitamin C dan A yang baik untuk sistem kekebalan tubuh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sawi',
                'price' => 6000,
                'image' => 'storage/fotoproduk/sawi.jpeg',
                'deskripsi' => 'Sawi adalah sayuran hijau yang kaya akan serat, vitamin A, C, dan K. Sawi membantu melancarkan pencernaan, menjaga kesehatan mata, dan mendukung sistem kekebalan tubuh.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
