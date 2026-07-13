<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductOption;
use App\Models\ProductOptionPriceRule;
use App\Models\ProductPriceRule;
use App\Models\ProductPriceTier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductDuplicateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_duplicate_product_with_related_data_and_options(): void
    {
        $admin = AdminUser::create([
            'name' => 'Product Admin',
            'email' => 'product-duplicate-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        $product = Product::create([
            'product_code' => 'HOTSTRAP-DUP',
            'translation_key' => 'product_duplicate_source',
            'product_name' => 'Hotstrap Duplicate Source',
            'description' => 'Original description',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
            'product_recomend' => 1,
            'product_recomend_menu' => 1,
            'product_premium' => 1,
            'can_upload_artwork' => 1,
            'artwork_required' => 1,
            'allow_no_artwork' => 1,
            'allow_text_print' => 1,
            'allow_font_select' => 1,
            'allow_template_select' => 1,
        ]);

        ProductDetail::create([
            'product_id' => $product->product_id,
            'sample_image' => 'products/sample.jpg',
            'specification_image' => 'products/spec.jpg',
            'detail_content' => ['intro' => 'detail'],
            'specification_content' => ['size' => '10mm'],
            'accordion_content' => ['faq' => 'content'],
            'is_active' => 1,
        ]);

        ProductImage::create([
            'product_id' => $product->product_id,
            'image_path' => 'products/main.jpg',
            'image_alt' => 'Original image',
            'image_type' => 'main',
            'is_main' => 1,
            'sort_order' => 1,
        ]);

        $group = OptionGroup::create([
            'group_code' => 'duplicate_group',
            'group_name' => 'Duplicate group',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $option = ProductOption::create([
            'option_group_id' => $group->option_group_id,
            'option_code' => 'DUP-OPTION',
            'option_name' => 'Duplicate option',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        DB::table('product_option_assignments')->insert([
            'product_id' => $product->product_id,
            'option_id' => $option->option_id,
            'sort_order' => 7,
            'is_default' => 1,
            'is_active' => 1,
            'qty_rule_type' => 'range',
            'min_qty' => 10,
            'max_qty' => 50,
            'exact_qty' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('product_option_group_orders')->insert([
            'product_id' => $product->product_id,
            'option_group_id' => $group->option_group_id,
            'sort_order' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ProductPriceTier::create([
            'product_id' => $product->product_id,
            'min_qty' => 1,
            'max_qty' => 9,
            'unit_price' => 100,
            'is_active' => 1,
        ]);

        $priceRule = ProductPriceRule::create([
            'product_id' => $product->product_id,
            'rule_name' => 'Duplicate price rule',
            'is_active' => 1,
            'sort_order' => 3,
        ]);
        $priceRule->options()->attach($option->option_id);
        $priceRule->tiers()->create([
            'min_qty' => 1,
            'max_qty' => 20,
            'unit_price' => 80,
            'unit_price_with_tax' => 88,
            'is_display' => 1,
            'is_active' => 1,
        ]);

        $optionPriceRule = ProductOptionPriceRule::create([
            'product_id' => $product->product_id,
            'target_option_id' => $option->option_id,
            'rule_name' => 'Duplicate option price rule',
            'is_active' => 1,
        ]);
        $optionPriceRule->options()->attach($option->option_id);
        $optionPriceRule->tiers()->create([
            'min_qty' => 1,
            'max_qty' => null,
            'additional_price' => 25,
            'additional_price_with_tax' => 27.5,
            'is_active' => 1,
        ]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->post('/admin-panel/products/'.$product->product_id.'/duplicate');

        $duplicate = Product::where('product_name', 'Hotstrap Duplicate Source - Copy')->firstOrFail();

        $response->assertRedirect(route('admin.products.edit', $duplicate->product_id));

        $this->assertNotSame($product->product_id, $duplicate->product_id);
        $this->assertSame(3, (int) $duplicate->is_active);
        $this->assertStringStartsWith('HOTSTRAP-DUP-copy', $duplicate->product_code);
        $this->assertNotSame($product->translation_key, $duplicate->translation_key);

        $this->assertDatabaseHas('product_details', [
            'product_id' => $duplicate->product_id,
            'sample_image' => 'products/sample.jpg',
        ]);

        $this->assertDatabaseHas('product_images', [
            'product_id' => $duplicate->product_id,
            'image_path' => 'products/main.jpg',
            'is_main' => 1,
        ]);

        $this->assertDatabaseHas('product_option_assignments', [
            'product_id' => $duplicate->product_id,
            'option_id' => $option->option_id,
            'sort_order' => 7,
            'is_default' => 1,
            'qty_rule_type' => 'range',
            'min_qty' => 10,
            'max_qty' => 50,
        ]);

        $this->assertDatabaseHas('product_option_group_orders', [
            'product_id' => $duplicate->product_id,
            'option_group_id' => $group->option_group_id,
            'sort_order' => 4,
        ]);

        $this->assertDatabaseHas('product_price_tiers', [
            'product_id' => $duplicate->product_id,
            'min_qty' => 1,
            'unit_price' => 100,
        ]);

        $duplicatedPriceRule = ProductPriceRule::where('product_id', $duplicate->product_id)
            ->where('rule_name', 'Duplicate price rule')
            ->firstOrFail();

        $this->assertDatabaseHas('product_price_rule_options', [
            'rule_id' => $duplicatedPriceRule->rule_id,
            'option_id' => $option->option_id,
        ]);

        $this->assertDatabaseHas('product_price_rule_tiers', [
            'rule_id' => $duplicatedPriceRule->rule_id,
            'unit_price' => 80,
            'unit_price_with_tax' => 88,
        ]);

        $duplicatedOptionPriceRule = ProductOptionPriceRule::where('product_id', $duplicate->product_id)
            ->where('rule_name', 'Duplicate option price rule')
            ->firstOrFail();

        $this->assertDatabaseHas('product_option_price_rule_options', [
            'option_price_rule_id' => $duplicatedOptionPriceRule->option_price_rule_id,
            'option_id' => $option->option_id,
        ]);

        $this->assertDatabaseHas('product_option_price_rule_tiers', [
            'option_price_rule_id' => $duplicatedOptionPriceRule->option_price_rule_id,
            'additional_price' => 25,
            'additional_price_with_tax' => 27.5,
        ]);
    }

    public function test_product_index_has_duplicate_action(): void
    {
        $contents = file_get_contents(resource_path('views/admin/products/index.blade.php'));

        $this->assertStringContainsString("route('admin.products.duplicate'", $contents);
        $this->assertStringContainsString('Duplicate this product?', $contents);
    }
}
