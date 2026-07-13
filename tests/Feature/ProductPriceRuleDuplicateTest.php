<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionAssignment;
use App\Models\ProductPriceRule;
use App\Models\ProductPriceRuleOption;
use App\Models\ProductPriceRuleTier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductPriceRuleDuplicateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_duplicate_form_can_switch_product_and_map_equivalent_options(): void
    {
        [$admin, $sourceProduct, $targetProduct, $sourceOption, $targetOption, $rule] = $this->createDuplicateScenario();

        $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.product-price-rules.index', ['product_id' => $sourceProduct->product_id]))
            ->assertOk()
            ->assertSee(route('admin.product-price-rules.duplicate', $rule), false);

        $response = $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.product-price-rules.duplicate', [
                'productPriceRule' => $rule,
                'product_id' => $targetProduct->product_id,
            ]));

        $response
            ->assertOk()
            ->assertViewIs('admin.product_price_rules.create')
            ->assertViewHas('selectedProductId', $targetProduct->product_id)
            ->assertViewHas('selectedOptionIds', [$targetOption->option_id])
            ->assertViewHas('duplicateRuleName', 'Source rule - Copy')
            ->assertViewHas('tiers', fn ($tiers) => (int) $tiers[0]['min_qty'] === 100
                && (float) $tiers[0]['unit_price'] === 9.50)
            ->assertSee('Source rule - Copy');

        $this->assertDatabaseHas('product_price_rule_options', [
            'rule_id' => $rule->rule_id,
            'option_id' => $sourceOption->option_id,
        ]);
        $this->assertSame($sourceProduct->product_id, $rule->fresh()->product_id);
    }

    public function test_duplicate_submission_creates_new_rule_for_selected_product(): void
    {
        [$admin, $sourceProduct, $targetProduct, $sourceOption, $targetOption, $rule] = $this->createDuplicateScenario();

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.product-price-rules.store'), [
                'product_id' => $targetProduct->product_id,
                'rule_name' => 'Target rule copy',
                'sort_order' => 4,
                'option_ids' => [$targetOption->option_id],
                'tiers' => [
                    [
                        'min_qty' => 100,
                        'unit_price' => 9.50,
                        'unit_price_with_tax' => 10.45,
                    ],
                ],
                'display_tier_index' => 0,
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.product-price-rules.index', [
            'product_id' => $targetProduct->product_id,
        ]));

        $copy = ProductPriceRule::where('product_id', $targetProduct->product_id)
            ->where('rule_name', 'Target rule copy')
            ->firstOrFail();

        $this->assertNotSame($rule->rule_id, $copy->rule_id);
        $this->assertDatabaseHas('product_price_rule_options', [
            'rule_id' => $copy->rule_id,
            'option_id' => $targetOption->option_id,
        ]);
        $this->assertDatabaseHas('product_price_rule_tiers', [
            'rule_id' => $copy->rule_id,
            'min_qty' => 100,
            'unit_price' => 9.50,
            'is_display' => 1,
        ]);

        $this->assertSame($sourceProduct->product_id, $rule->fresh()->product_id);
        $this->assertDatabaseHas('product_price_rule_options', [
            'rule_id' => $rule->rule_id,
            'option_id' => $sourceOption->option_id,
        ]);
    }

    public function test_store_rejects_option_that_is_not_assigned_to_selected_product(): void
    {
        [$admin, , $targetProduct, $sourceOption] = $this->createDuplicateScenario();

        $response = $this
            ->actingAs($admin, 'admin')
            ->from(route('admin.product-price-rules.create'))
            ->post(route('admin.product-price-rules.store'), [
                'product_id' => $targetProduct->product_id,
                'rule_name' => 'Invalid copied rule',
                'option_ids' => [$sourceOption->option_id],
                'tiers' => [
                    [
                        'min_qty' => 1,
                        'unit_price' => 10,
                    ],
                ],
                'is_active' => 1,
            ]);

        $response
            ->assertRedirect(route('admin.product-price-rules.create'))
            ->assertSessionHasErrors('option_ids');

        $this->assertDatabaseMissing('product_price_rules', [
            'product_id' => $targetProduct->product_id,
            'rule_name' => 'Invalid copied rule',
        ]);
    }

    private function createDuplicateScenario(): array
    {
        $admin = AdminUser::create([
            'name' => 'Price Rule Admin',
            'email' => 'price-rule-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        $sourceProduct = Product::create([
            'product_name' => 'Source product',
            'product_code' => 'PRICE-SOURCE-'.uniqid(),
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $targetProduct = Product::create([
            'product_name' => 'Target product',
            'product_code' => 'PRICE-TARGET-'.uniqid(),
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $group = OptionGroup::create([
            'group_code' => 'price_rule_size_'.uniqid(),
            'group_name' => 'Size',
            'language' => 'pt',
            'product_type' => 1,
            'option_group_main' => 1,
            'is_active' => 1,
        ]);

        $translationKey = 'price-rule-option-'.uniqid();

        $sourceOption = ProductOption::create([
            'option_group_id' => $group->option_group_id,
            'option_code' => '20MM',
            'option_name' => '20 mm source',
            'translation_key' => $translationKey,
            'additional_price' => 0,
            'price_type' => 'per_item',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        $targetOption = ProductOption::create([
            'option_group_id' => $group->option_group_id,
            'option_code' => '20MM',
            'option_name' => '20 mm target',
            'translation_key' => $translationKey,
            'additional_price' => 0,
            'price_type' => 'per_item',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        foreach ([[$sourceProduct, $sourceOption], [$targetProduct, $targetOption]] as $index => [$product, $option]) {
            ProductOptionAssignment::create([
                'product_id' => $product->product_id,
                'option_id' => $option->option_id,
                'sort_order' => $index + 1,
                'is_default' => 0,
                'is_active' => 1,
            ]);
        }

        $rule = ProductPriceRule::create([
            'product_id' => $sourceProduct->product_id,
            'rule_name' => 'Source rule',
            'sort_order' => 4,
            'is_active' => 1,
        ]);

        ProductPriceRuleOption::create([
            'rule_id' => $rule->rule_id,
            'option_id' => $sourceOption->option_id,
        ]);

        ProductPriceRuleTier::create([
            'rule_id' => $rule->rule_id,
            'min_qty' => 100,
            'max_qty' => null,
            'unit_price' => 9.50,
            'unit_price_with_tax' => 10.45,
            'is_display' => 1,
            'is_active' => 1,
        ]);

        return [$admin, $sourceProduct, $targetProduct, $sourceOption, $targetOption, $rule];
    }
}
