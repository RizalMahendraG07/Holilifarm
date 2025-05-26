<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'stok' => $this->faker->numberBetween(1, 100),
            'deskripsi' => $this->faker->sentence(),
            'image' => 'storage/fotoproduk/1o8GwvzJsoVCGKx3e9ZAg0tvIYnjV18SkKzuGz1V.jpg', // atau sesuaikan default image
        ];
    }
}
