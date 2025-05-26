<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Riwayat;
use App\Models\Product;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RiwayatTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use WithoutMiddleware;
    public function test_user_dapat_mengakses_manajemen_riwayat(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/riwayat');

        $response->assertStatus(200);
        $response->assertSee('riwayat');
        $this->assertAuthenticatedAs($user);
    }

   public function test_user_dapat_menambah_riwayat(): void
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $data = [
        'nama_pembeli'   => 'John Doe',
        'alamat'         => 'Jl. Testing No. 123',
        'produk_id'      => $product->id,
        'jumlah_produk'  => 3,
        'harga_total'    => $product->price * 3,
        'status'         => 'Proses',
    ];

    $response = $this->actingAs($user)->post('/riwayat', $data);

    $response->assertStatus(302); // asumsi redirect setelah simpan

    $this->assertDatabaseHas('riwayats', $data);
}

    public function test_user_dapat_mengedit_riwayat(): void
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $riwayat = Riwayat::create([
        'nama_pembeli'   => 'Jane Doe',
        'alamat'         => 'Jl. Lama',
        'produk_id'      => $product->id,
        'jumlah_produk'  => 2,
        'harga_total'    => $product->price * 2,
        'status'         => 'Proses',
    ]);

    $updatedData = [
        'nama_pembeli'   => 'Jane Smith',
        'alamat'         => 'Jl. Baru No. 456',
        'produk_id'      => $product->id,
        'jumlah_produk'  => 5,
        'harga_total'    => $product->price * 5,
        'status'         => 'Selesai',
    ];

    $response = $this->actingAs($user)->put("/riwayat/{$riwayat->id}", $updatedData);

    $response->assertStatus(302); // asumsi redirect setelah update

    $this->assertDatabaseHas('riwayats', $updatedData);
}

public function test_user_dapat_menghapus_riwayat(): void
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $riwayat = Riwayat::create([
        'nama_pembeli'   => 'Hapus Ini',
        'alamat'         => 'Jl. Hapus',
        'produk_id'      => $product->id,
        'jumlah_produk'  => 1,
        'harga_total'    => $product->price,
        'status'         => 'Proses',
    ]);

    $response = $this->actingAs($user)->delete("/riwayat/{$riwayat->id}");

    $response->assertStatus(302); // asumsi redirect setelah delete

    $this->assertDatabaseMissing('riwayats', [
        'id' => $riwayat->id,
    ]);
}

}
