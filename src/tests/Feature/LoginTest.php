<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_halaman_login_tampil()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login');
    }

   public function test_user_bisa_login()
{
    $password = '123456'; // password plaintext yang ingin kamu pakai

    $user = User::factory()->create([
        'email' => 'ilhamisdarmawan@gmail.com',
        'password' => bcrypt($password), // simpan hashed password
    ]);

    // Lakukan post request ke route login dengan data yang benar
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => $password,
    ]);

    $response->assertRedirect('/grafik'); // Pastikan setelah login redirect ke grafik (sesuaikan)

    // Cek user sudah login
    $this->assertAuthenticatedAs($user);

    // Akses halaman yang dilindungi
    $response = $this->get('/grafik');
    $response->assertStatus(200);
}



}
