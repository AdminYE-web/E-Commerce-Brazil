<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionAssignment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductOptionAssignmentControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_updating_visible_product_options_preserves_assignments_outside_current_edit_scope(): void
    {
        $admin = AdminUser::create([
            'name' => 'Options Admin',
            'email' => 'options-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        $product = Product::create([
            'product_name' => 'PT Product',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $visibleGroup = OptionGroup::create([
            'group_code' => 'visible_group',
            'group_name' => 'Visible group',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $hiddenGroup = OptionGroup::create([
            'group_code' => 'hidden_group',
            'group_name' => 'Hidden group',
            'language' => 'ja',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $existingVisibleOption = ProductOption::create([
            'option_group_id' => $visibleGroup->option_group_id,
            'option_name' => 'Existing visible option',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        $newVisibleOption = ProductOption::create([
            'option_group_id' => $visibleGroup->option_group_id,
            'option_name' => 'New visible option',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        $hiddenAssignedOption = ProductOption::create([
            'option_group_id' => $hiddenGroup->option_group_id,
            'option_name' => 'Hidden assigned option',
            'language' => 'ja',
            'is_active' => 1,
        ]);

        ProductOptionAssignment::create([
            'product_id' => $product->product_id,
            'option_id' => $existingVisibleOption->option_id,
            'sort_order' => 1,
            'is_default' => 0,
            'is_active' => 1,
        ]);

        ProductOptionAssignment::create([
            'product_id' => $product->product_id,
            'option_id' => $hiddenAssignedOption->option_id,
            'sort_order' => 2,
            'is_default' => 0,
            'is_active' => 1,
        ]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->put(route('admin.products.options.update', $product->product_id), [
                'options' => [
                    $existingVisibleOption->option_id => [
                        'option_id' => $existingVisibleOption->option_id,
                        'sort_order' => 1,
                        'is_active' => 1,
                    ],
                    $newVisibleOption->option_id => [
                        'option_id' => $newVisibleOption->option_id,
                        'sort_order' => 2,
                        'is_active' => 1,
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('product_option_assignments', [
            'product_id' => $product->product_id,
            'option_id' => $hiddenAssignedOption->option_id,
        ]);

        $this->assertDatabaseHas('product_option_assignments', [
            'product_id' => $product->product_id,
            'option_id' => $newVisibleOption->option_id,
        ]);
    }

    public function test_selected_option_ids_attach_even_when_nested_option_payload_is_missing(): void
    {
        $admin = AdminUser::create([
            'name' => 'Options Admin',
            'email' => 'options-admin-selected-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        $product = Product::create([
            'product_name' => 'PT Product',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $visibleGroup = OptionGroup::create([
            'group_code' => 'visible_group_selected',
            'group_name' => 'Visible group selected',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $existingVisibleOption = ProductOption::create([
            'option_group_id' => $visibleGroup->option_group_id,
            'option_name' => 'Existing visible option',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        $newVisibleOption = ProductOption::create([
            'option_group_id' => $visibleGroup->option_group_id,
            'option_name' => 'New selected option',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        ProductOptionAssignment::create([
            'product_id' => $product->product_id,
            'option_id' => $existingVisibleOption->option_id,
            'sort_order' => 1,
            'is_default' => 0,
            'is_active' => 1,
        ]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->put(route('admin.products.options.update', $product->product_id), [
                'selected_options' => [
                    $existingVisibleOption->option_id,
                    $newVisibleOption->option_id,
                ],
                'options' => [
                    $existingVisibleOption->option_id => [
                        'option_id' => $existingVisibleOption->option_id,
                        'sort_order' => 1,
                        'is_active' => 1,
                    ],
                ],
            ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('product_option_assignments', [
            'product_id' => $product->product_id,
            'option_id' => $newVisibleOption->option_id,
            'is_active' => 1,
        ]);
    }
}
