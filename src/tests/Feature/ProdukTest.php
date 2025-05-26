<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProdukTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * Test user dapat mengakses halaman manajemen produk.
     */
    public function test_user_dapat_mengakses_manajemen_produk_setelah_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/produk');

        $response->assertStatus(200);
        $response->assertSee('produk');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user dapat menambah produk menggunakan data factory.
     */
    public function test_user_dapat_menambah_produk(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        // Buat fake image untuk upload
        
        $file = UploadedFile::fake()->create('produk.jpg', 100);

        // Ambil data produk dari factory tanpa simpan ke DB (make), lalu ambil atributnya
        $produkData = Product::factory()->make()->toArray();

        // Ganti field image dengan file fake upload
        $produkData['image'] = $file;

        $response = $this->actingAs($user)
                         ->post('/products', $produkData);

        $response->assertStatus(302); // redirect setelah berhasil simpan

        // Pastikan data produk tersimpan di database (kecuali image, karena disimpan pathnya)
        $this->assertDatabaseHas('products', [
            'name' => $produkData['name'],
            'price' => $produkData['price'],
            'stok' => $produkData['stok'],
            'deskripsi' => $produkData['deskripsi'],
            // image tidak dicek string lengkap karena random, tapi bisa dicek file storage
        ]);

        // Cek file gambar berhasil disimpan di disk public
        Storage::disk('public')->assertExists('fotoproduk/' . $file->hashName());
    }

    /**
     * Test user dapat mengedit produk menggunakan data factory.
     */
    public function test_user_dapat_mengedit_produk(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        // Buat produk awal di database
        $produk = Product::factory()->create();

        // Buat data update baru menggunakan factory (make)
        $updatedData = Product::factory()->make()->toArray();

        // Buat file image baru fake
        $file = UploadedFile::fake()->create('produk_update.jpg',100);

        $updatedData['image'] = $file;

        $response = $this->actingAs($user)
                         ->put('/products/' . $produk->id, $updatedData);

        $response->assertStatus(302); // redirect setelah update berhasil

        // Pastikan data produk di DB sudah berubah sesuai update
        $this->assertDatabaseHas('products', [
            'id' => $produk->id,
            'name' => $updatedData['name'],
            'price' => $updatedData['price'],
            'stok' => $updatedData['stok'],
            'deskripsi' => $updatedData['deskripsi'],
        ]);

        // Cek file gambar update tersimpan di disk
        Storage::disk('public')->assertExists('fotoproduk/' . $file->hashName());
    }

    public function test_user_dapat_menghapus_produk(): void
    {
        $user = User::factory()->create();

        // Buat produk awal di database
        $produk = Product::factory()->create();

        $response = $this->actingAs($user)
                         ->delete('/products/' . $produk->id);

        $response->assertStatus(302); // redirect setelah delete berhasil

        // Pastikan produk sudah tidak ada di database
        $this->assertDatabaseMissing('products', [
            'id' => $produk->id,
        ]);
       
    }
}
