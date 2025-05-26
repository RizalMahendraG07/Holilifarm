<?php

namespace Database\Factories;

use App\Models\Riwayat;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatFactory extends Factory
{
    protected $model = Riwayat::class;

    public function definition(): array
    {
        return [
            'nama_pembeli'   => $this->faker->name(),
            'alamat'         => $this->faker->address(),
            'produk_id'      => Product::factory(), // relasi dengan product
            'jumlah_produk'  => $this->faker->numberBetween(1, 10),
            'harga_total'    => $this->faker->numberBetween(10000, 100000),
            'status'         => $this->faker->randomElement(['Selesai', 'Proses', 'Cancel']),
        ];
    }
}
