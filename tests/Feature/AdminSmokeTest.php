<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_pages_are_accessible_for_admin_user(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'Aktif',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get(route('produk.index'))
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get(route('kategori.index'))
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get(route('pesanan.index'))
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get(route('daftar-user.index'))
            ->assertStatus(200);
    }

    public function test_admin_pages_require_authentication(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));

        $this->get(route('produk.index'))
            ->assertRedirect(route('login'));

        $this->get(route('kategori.index'))
            ->assertRedirect(route('login'));

        $this->get(route('pesanan.index'))
            ->assertRedirect(route('login'));

        $this->get(route('daftar-user.index'))
            ->assertRedirect(route('login'));
    }
}
