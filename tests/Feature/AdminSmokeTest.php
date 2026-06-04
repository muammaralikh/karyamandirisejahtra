<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $this->actingAs($admin)
            ->get(route('activity-logs.index'))
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

        $this->get(route('activity-logs.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_mark_pending_order_as_lunas_with_payment_proof(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'Aktif',
        ]);
        $customer = User::factory()->create();
        $order = $this->createOrder($customer);

        $this->actingAs($admin)
            ->put(route('pesanan.update', $order->id), [
                'payment_proof' => UploadedFile::fake()->image('bukti-transfer.jpg'),
            ])
            ->assertRedirect();

        $order->refresh();

        $this->assertSame('lunas', $order->status);
        $this->assertNotNull($order->paid_at);
        $this->assertNotNull($order->payment_proof);
        Storage::disk('public')->assertExists($order->payment_proof);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'konfirmasi_lunas',
            'subject_id' => (string) $order->id,
        ]);
    }

    public function test_expired_pending_orders_are_cancelled_when_admin_opens_orders_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'Aktif',
        ]);
        $customer = User::factory()->create();
        $order = $this->createOrder($customer, [
            'created_at' => now()->subDay()->subMinute(),
            'updated_at' => now()->subDay()->subMinute(),
        ]);

        $this->actingAs($admin)
            ->get(route('pesanan.index'))
            ->assertStatus(200);

        $order->refresh();

        $this->assertSame('cancelled', $order->status);
        $this->assertSame('Batal - tidak ada konfirmasi pembayaran dalam 1x24 jam.', $order->cancellation_reason);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'auto_batal_pesanan',
            'subject_id' => (string) $order->id,
        ]);
    }

    public function test_admin_can_delete_pending_order_before_lunas_confirmation(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'Aktif',
        ]);
        $customer = User::factory()->create();
        $order = $this->createOrder($customer);

        $this->actingAs($admin)
            ->delete(route('pesanan.destroy', $order->id))
            ->assertRedirect(route('pesanan.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'hapus_pesanan',
            'subject_label' => $order->order_number,
        ]);
    }

    public function test_admin_cannot_delete_lunas_order_after_confirmation(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'Aktif',
        ]);
        $customer = User::factory()->create();
        $order = $this->createOrder($customer, [
            'status' => 'lunas',
            'paid_at' => now(),
            'payment_proof' => 'payment-proofs/bukti-transfer.jpg',
        ]);

        $this->actingAs($admin)
            ->delete(route('pesanan.destroy', $order->id))
            ->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'lunas',
        ]);
    }

    private function createOrder(User $customer, array $overrides = []): Order
    {
        $order = Order::create(array_merge([
            'user_id' => $customer->id,
            'order_number' => 'ORD-TEST-' . fake()->unique()->numerify('####'),
            'status' => 'pending',
            'subtotal' => 30000,
            'shipping_cost' => 10000,
            'total' => 40000,
            'shipping_method' => 'Ongkir',
            'payment_method' => 'Transfer Bank',
            'recipient_name' => 'Hana',
            'recipient_phone' => '089505659185',
            'shipping_address' => 'Purwokerto Barat, Banyumas',
        ], $overrides));

        $timestampOverrides = array_intersect_key($overrides, array_flip(['created_at', 'updated_at']));

        if ($timestampOverrides !== []) {
            $order->forceFill($timestampOverrides)->save();
        }

        return $order;
    }
}
