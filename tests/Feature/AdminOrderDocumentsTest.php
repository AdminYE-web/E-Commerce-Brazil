<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminOrderDocumentsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_download_order_quotation_pdf(): void
    {
        [$admin, $order] = $this->adminAndOrder();

        $response = $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.orders.quotation', $order));

        $response
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->assertStringContainsString(
            'quotation-'.$order->order_no.'.pdf',
            $response->headers->get('content-disposition')
        );
    }

    public function test_admin_can_download_order_invoice_pdf(): void
    {
        [$admin, $order] = $this->adminAndOrder();

        $response = $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.orders.invoice', $order));

        $response
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->assertStringContainsString(
            'invoice-'.$order->order_no.'.pdf',
            $response->headers->get('content-disposition')
        );
    }

    /**
     * @return array{0: AdminUser, 1: Order}
     */
    private function adminAndOrder(): array
    {
        $admin = AdminUser::create([
            'name' => 'Admin User',
            'email' => 'admin-documents@example.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
            'is_active' => 1,
        ]);

        $order = Order::create([
            'order_no' => 'ORD-DOC-001',
            'qty' => 10,
            'base_unit_price' => 100,
            'option_total' => 50,
            'subtotal' => 1050,
            'vat_amount' => 105,
            'shipping_fee' => 300,
            'grand_total' => 1455,
            'status' => 'pending',
            'order_status' => 'order_pending',
            'payment_status' => 'pending',
        ]);

        OrderCustomer::create([
            'order_id' => $order->order_id,
            'personal_first_name' => 'Maria',
            'personal_last_name' => 'Santos',
            'personal_phone' => '+55 11 98888-1234',
            'personal_email' => 'maria@example.com',
            'shipping_postcode' => '100-0001',
            'shipping_province' => 'Tokyo',
            'shipping_district' => 'Chiyoda',
            'shipping_subdistrict' => 'Marunouchi',
            'shipping_building_room' => 'Room 101',
            'shipping_address' => '1-1 Marunouchi',
        ]);

        OrderItem::create([
            'order_id' => $order->order_id,
            'product_id' => 1,
            'product_name' => 'Custom Lanyard',
            'product_name_snapshot' => 'Custom Lanyard',
            'qty' => 10,
            'quantity' => 10,
            'base_unit_price' => 100,
            'unit_price' => 105,
            'base_total' => 1000,
            'product_total' => 1000,
            'option_total' => 50,
            'item_total' => 1050,
            'options' => [
                [
                    'group_name' => 'Color',
                    'option_name' => 'Blue',
                ],
            ],
        ]);

        OrderPayment::create([
            'order_id' => $order->order_id,
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending',
            'amount' => 1455,
            'currency' => 'JPY',
        ]);

        return [$admin, $order];
    }
}
