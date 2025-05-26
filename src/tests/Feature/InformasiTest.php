<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Informasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class InformasiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /** @test */
    public function test_user_dapat_mengakses_manajemen_informasi_setelah_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/informasi');

        $response->assertStatus(200);
        $response->assertSee('informasi');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_user_dapat_menambah_informasi(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $data = Informasi::factory()->make()->toArray();

        // Tambahkan data tanggal dan link sesuai validasi
        $data['Tanggal'] = now()->toDateString();
        $data['link'] = 'https://example.com';

        $data['foto'] = UploadedFile::fake()->create('informasi.jpg');

        $response = $this->actingAs($user)->post('/informasi', $data);

        $response->assertStatus(302); // redirect setelah berhasil

        $this->assertDatabaseHas('informasis', [
            'Judul' => $data['Judul'],
            'Deskripsi' => $data['Deskripsi'],
            'Tanggal' => $data['Tanggal'],
            'link' => $data['link'],
        ]);

        Storage::disk('public')->assertExists('foto_informasi/' . $data['foto']->hashName());
    }

    /** @test */
    public function test_user_dapat_mengedit_informasi(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $informasi = Informasi::factory()->create();

        $updated = Informasi::factory()->make()->toArray();

        $updated['Tanggal'] = now()->toDateString();
        $updated['link'] = 'https://example.com';
        $updated['foto'] = UploadedFile::fake()->create('updated.jpg');

        $response = $this->actingAs($user)->put("/informasi/{$informasi->id}", $updated);

        $response->assertStatus(302);

        $this->assertDatabaseHas('informasis', [
            'id' => $informasi->id,
            'Judul' => $updated['Judul'],
            'Deskripsi' => $updated['Deskripsi'],
            'Tanggal' => $updated['Tanggal'],
            'link' => $updated['link'],
        ]);

        Storage::disk('public')->assertExists('foto_informasi/' . $updated['foto']->hashName());
    }

    /** @test */
    public function test_user_dapat_menghapus_informasi(): void
    {
        $user = User::factory()->create();
        $informasi = Informasi::factory()->create();

        $response = $this->actingAs($user)->delete("/informasi/{$informasi->id}");

        $response->assertStatus(302);

        $this->assertDatabaseMissing('informasis', [
            'id' => $informasi->id,
        ]);
    }
}
