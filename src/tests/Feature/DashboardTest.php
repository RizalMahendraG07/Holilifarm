<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class DashboardTest extends TestCase
{
        use RefreshDatabase;
    public function test_user_dapat_mengakses_dashboard_setelah_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/grafik');

        $response->assertStatus(200);
        $response->assertSee('grafik'); // sesuaikan huruf besar kecil dengan blade view kamu
        $this->assertAuthenticatedAs($user);
    }
}
