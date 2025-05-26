<?php

namespace Database\Factories;

use App\Models\Informasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class InformasiFactory extends Factory
{
    protected $model = Informasi::class;

    public function definition(): array
    {
        return [
            'Judul' => $this->faker->sentence(3),
            'Deskripsi' => $this->faker->paragraph(),
            'foto' => 'storage/fotoinformasi/default.jpg',
            'Tanggal' => now()->toDateString(),
            'link' => $this->faker->url(),
        ];
    }
}
