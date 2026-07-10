<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionAssignment;
use App\Models\ProductOptionPriceRule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductOptionPriceRuleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_store_target_option_separately_from_required_options(): void
    {
        $admin = AdminUser::create([
            'name' => 'Option Rule Admin',
            'email' => 'option-rule-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        [$product, $targetOption, $conditionOption] = $this->createProductWithTargetAndConditionOptions();

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.option-price-rules.store'), [
                'product_id' => $product->product_id,
                'rule_name' => 'Black cord + 20mm',
                'target_option_id' => $targetOption->option_id,
                'option_ids' => [
                    $conditionOption->option_id,
                ],
                'tiers' => [
                    [
                        'min_qty' => 1,
                        'max_qty' => null,
                        'additional_price' => 50,
                        'additional_price_with_tax' => 55,
                    ],
                    [
                        'min_qty' => 10,
                        'max_qty' => null,
                        'additional_price' => 20,
                        'additional_price_with_tax' => 22,
                    ],
                ],
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.option-price-rules.index'));

        $this->assertDatabaseHas('product_option_price_rules', [
            'product_id' => $product->product_id,
            'rule_name' => 'Black cord + 20mm',
            'target_option_id' => $targetOption->option_id,
        ]);

        $rule = ProductOptionPriceRule::where('rule_name', 'Black cord + 20mm')->firstOrFail();

        $this->assertDatabaseHas('product_option_price_rule_options', [
            'option_price_rule_id' => $rule->option_price_rule_id,
            'option_id' => $conditionOption->option_id,
        ]);
    }

    public function test_admin_can_store_target_option_as_one_of_the_required_options(): void
    {
        $admin = AdminUser::create([
            'name' => 'Option Rule Admin',
            'email' => 'option-rule-self-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        [$product, $targetOption, $conditionOption] = $this->createProductWithTargetAndConditionOptions();

        $response = $this
            ->actingAs($admin, 'admin')
            ->post(route('admin.option-price-rules.store'), [
                'product_id' => $product->product_id,
                'rule_name' => 'Black cord self condition + 20mm',
                'target_option_id' => $targetOption->option_id,
                'option_ids' => [
                    $targetOption->option_id,
                    $conditionOption->option_id,
                ],
                'tiers' => [
                    [
                        'min_qty' => 1,
                        'max_qty' => null,
                        'additional_price' => 50,
                        'additional_price_with_tax' => 55,
                    ],
                ],
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.option-price-rules.index'));

        $rule = ProductOptionPriceRule::where('rule_name', 'Black cord self condition + 20mm')->firstOrFail();

        $this->assertDatabaseHas('product_option_price_rule_options', [
            'option_price_rule_id' => $rule->option_price_rule_id,
            'option_id' => $targetOption->option_id,
        ]);
        $this->assertDatabaseHas('product_option_price_rule_options', [
            'option_price_rule_id' => $rule->option_price_rule_id,
            'option_id' => $conditionOption->option_id,
        ]);
    }

    public function test_option_rule_form_does_not_disable_required_option_that_matches_target_option(): void
    {
        $createContents = file_get_contents(resource_path('views/admin/option_price_rules/create.blade.php'));
        $editContents = file_get_contents(resource_path('views/admin/option_price_rules/edit.blade.php'));

        $this->assertStringNotContainsString('checkbox.disabled = Boolean(isTarget);', $createContents);
        $this->assertStringNotContainsString('checkbox.checked = false;', $createContents);
        $this->assertStringNotContainsString("if (e.target && e.target.name === 'target_option_id')", $createContents);
        $this->assertStringContainsString("productSelect.addEventListener('change'", $createContents);
        $this->assertStringContainsString('loadProductOptions(productSelect.value);', $createContents);
        $this->assertStringContainsString('const groupCode = group.group_code', $createContents);
        $this->assertStringContainsString('${groupName}${groupCode}', $createContents);

        $this->assertStringNotContainsString('checkbox.disabled = Boolean(isTarget);', $editContents);
        $this->assertStringNotContainsString('checkbox.checked = false;', $editContents);
        $this->assertStringNotContainsString("if (e.target && e.target.name === 'target_option_id')", $editContents);
        $this->assertStringContainsString('loadProductOptions(productIdInput.value);', $editContents);
    }

    public function test_product_options_endpoint_includes_group_and_option_codes_for_admin_rule_forms(): void
    {
        $admin = AdminUser::create([
            'name' => 'Option Rule Admin',
            'email' => 'option-rule-code-admin-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => 1,
        ]);

        [$product] = $this->createProductWithTargetAndConditionOptions();

        $response = $this
            ->actingAs($admin, 'admin')
            ->getJson(route('admin.product-price-rules.product-options', $product));

        $response
            ->assertOk()
            ->assertJsonPath('groups.0.group_name', 'Cord Color')
            ->assertJsonPath('groups.0.group_code', 'cord_color_test')
            ->assertJsonPath('groups.0.options.0.option_name', 'Black cord')
            ->assertJsonPath('groups.0.options.0.option_code', 'BLACK');
    }

    public function test_cart_uses_matching_option_price_rule_as_target_option_replacement_price(): void
    {
        [$product, $targetOption, $conditionOption] = $this->createProductWithTargetAndConditionOptions();

        $rule = ProductOptionPriceRule::create([
            'product_id' => $product->product_id,
            'target_option_id' => $targetOption->option_id,
            'rule_name' => 'Black cord + 20mm',
            'is_active' => 1,
        ]);

        $rule->options()->sync([$conditionOption->option_id]);
        $rule->tiers()->create([
            'min_qty' => 1,
            'max_qty' => null,
            'additional_price' => 50,
            'additional_price_with_tax' => 55,
            'is_active' => 1,
        ]);
        $rule->tiers()->create([
            'min_qty' => 10,
            'max_qty' => null,
            'additional_price' => 20,
            'additional_price_with_tax' => 22,
            'is_active' => 1,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->product_id,
            'quantity' => 10,
            'options' => [
                $targetOption->option_group_id => $targetOption->option_id,
                $conditionOption->option_group_id => $conditionOption->option_id,
            ],
        ]);

        $response->assertRedirect(route('cart.index'));

        $cart = session('cart');
        $item = collect($cart)->first();

        $this->assertSame(200.0, (float) $item['option_total']);
        $this->assertSame(200.0, (float) $item['item_total']);

        $targetCartOption = collect($item['options'])->firstWhere('option_id', $targetOption->option_id);

        $this->assertSame(20.0, (float) $targetCartOption['price']);
    }

    public function test_cart_index_keeps_option_price_rule_replacement_when_recalculating_totals(): void
    {
        [$product, $targetOption, $conditionOption] = $this->createProductWithTargetAndConditionOptions();

        $targetOption->update([
            'additional_price' => 0,
            'additional_price_with_tax' => 0,
            'price_type' => 'per_order',
        ]);

        $rule = ProductOptionPriceRule::create([
            'product_id' => $product->product_id,
            'target_option_id' => $targetOption->option_id,
            'rule_name' => 'Two side printed + holder',
            'is_active' => 1,
        ]);

        $rule->options()->sync([
            $targetOption->option_id,
            $conditionOption->option_id,
        ]);
        $rule->tiers()->create([
            'min_qty' => 1,
            'max_qty' => null,
            'additional_price' => 20,
            'additional_price_with_tax' => 22,
            'is_active' => 1,
        ]);

        $this->post(route('cart.add'), [
            'product_id' => $product->product_id,
            'quantity' => 1,
            'options' => [
                $targetOption->option_group_id => $targetOption->option_id,
                $conditionOption->option_group_id => $conditionOption->option_id,
            ],
        ])->assertRedirect(route('cart.index'));

        $this->assertSame(20.0, (float) collect(session('cart'))->first()['option_total']);

        $this->get(route('cart.index'))->assertOk();

        $item = collect(session('cart'))->first();
        $targetCartOption = collect($item['options'])->firstWhere('option_id', $targetOption->option_id);

        $this->assertSame(20.0, (float) $targetCartOption['price']);
        $this->assertSame(20.0, (float) $item['option_total']);
        $this->assertSame(20.0, (float) $item['item_total']);
    }

    public function test_product_detail_pages_apply_option_price_rules_in_live_summary(): void
    {
        $hotstrapContents = file_get_contents(resource_path('views/products/hotstrap_show.blade.php'));
        $hotmobilyContents = file_get_contents(resource_path('views/products/hotmobily_show.blade.php'));
        $controllerContents = file_get_contents(app_path('Http/Controllers/ProductListController.php'));

        foreach ([$hotstrapContents, $hotmobilyContents] as $contents) {
            $this->assertStringContainsString('const optionPriceRules = @json($optionPriceRules ?? []);', $contents);
            $this->assertStringContainsString('function findMatchedOptionPriceRule(targetOptionId, selectedOptionIds)', $contents);
            $this->assertStringContainsString('function getOptionReplacementPrice(optionId, currentPrice, quantity, selectedOptionIds)', $contents);
            $this->assertStringContainsString('finalPrice = getOptionReplacementPrice(optionId, finalPrice, quantity, selectedOptionIds);', $contents);
        }

        $this->assertStringContainsString("'optionPriceRules.options'", $controllerContents);
        $this->assertStringContainsString("'optionPriceRules.tiers'", $controllerContents);
        $this->assertStringContainsString("'optionPriceRules'", $controllerContents);
    }

    private function createProductWithTargetAndConditionOptions(): array
    {
        $product = Product::create([
            'product_name' => 'Hotstrap test product',
            'product_code' => 'HOTSTRAP-TEST',
            'language' => 'pt',
            'product_type' => 1,
            'is_active' => 1,
        ]);

        $cordGroup = OptionGroup::create([
            'group_code' => 'cord_color_test',
            'group_name' => 'Cord Color',
            'language' => 'pt',
            'product_type' => 1,
            'option_group_main' => 1,
            'is_active' => 1,
        ]);

        $sizeGroup = OptionGroup::create([
            'group_code' => 'cord_size_test',
            'group_name' => 'Cord Size',
            'language' => 'pt',
            'product_type' => 1,
            'option_group_main' => 1,
            'is_active' => 1,
        ]);

        $targetOption = ProductOption::create([
            'option_group_id' => $cordGroup->option_group_id,
            'option_code' => 'BLACK',
            'option_name' => 'Black cord',
            'additional_price' => 100,
            'price_type' => 'per_item',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        $conditionOption = ProductOption::create([
            'option_group_id' => $sizeGroup->option_group_id,
            'option_code' => '20MM',
            'option_name' => '20mm',
            'additional_price' => 0,
            'price_type' => 'per_item',
            'language' => 'pt',
            'is_active' => 1,
        ]);

        foreach ([$targetOption, $conditionOption] as $index => $option) {
            ProductOptionAssignment::create([
                'product_id' => $product->product_id,
                'option_id' => $option->option_id,
                'sort_order' => $index + 1,
                'is_default' => 0,
                'is_active' => 1,
            ]);
        }

        return [$product, $targetOption, $conditionOption];
    }
}
