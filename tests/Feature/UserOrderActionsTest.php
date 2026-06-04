<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOrderActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_order_page_does_not_show_payment_upload_or_delete_actions(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'status' => 'Aktif',
        ]);

        Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-USER-0001',
            'status' => 'pending',
            'subtotal' => 25000,
            'shipping_cost' => 0,
            'total' => 25000,
            'shipping_method' => 'Ambil di Tempat',
            'payment_method' => 'Transfer Bank',
            'recipient_name' => 'Hana',
            'recipient_phone' => '089505659185',
            'shipping_address' => 'Purwokerto Barat, Banyumas',
        ]);

        $this->actingAs($user)
            ->get(route('user.account.my-account'))
            ->assertStatus(200)
            ->assertSee('Pesanan akan dikonfirmasi oleh admin')
            ->assertDontSee('Upload Bukti Transfer')
            ->assertDontSee('Hapus Pesanan');
    }
}
