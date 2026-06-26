<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class ProductDetailLocalizationTest extends TestCase
{
    public function test_cart_submit_buttons_use_translations_on_product_detail_pages(): void
    {
        foreach (['hotstrap_show', 'hotmobily_show'] as $view) {
            $contents = file_get_contents(resource_path("views/products/{$view}.blade.php"));

            $this->assertStringContainsString(
                "__('product.product_detail.update_cart')",
                $contents
            );
            $this->assertStringContainsString(
                "__('product.product_detail.add_to_cart')",
                $contents
            );
            $this->assertStringNotContainsString("'UPDATE CART'", $contents);
            $this->assertStringNotContainsString("'ADD TO CART'", $contents);
        }
    }

    public function test_cart_submit_button_translations_exist_for_supported_locales(): void
    {
        foreach (['pt', 'ja', 'en'] as $locale) {
            Lang::setLocale($locale);

            $this->assertTrue(Lang::has('product.product_detail.update_cart'));
            $this->assertTrue(Lang::has('product.product_detail.add_to_cart'));
        }
    }

    public function test_hotstrap_select_detail_dropdown_starts_empty(): void
    {
        $contents = file_get_contents(resource_path('views/products/hotstrap_show.blade.php'));

        $this->assertStringContainsString(
            "{{ \$selectedOption?->option_name ?? 'Please select' }}",
            $contents
        );
        $this->assertStringContainsString("label.textContent = 'Please select';", $contents);
        $this->assertStringNotContainsString(
            '$selectedOption = $selectedOption ?? $defaultOption;',
            $contents
        );
        $this->assertStringNotContainsString('selectFirstAvailableBootstrapItem(wrap);', $contents);
    }

    public function test_hotstrap_checked_radio_click_can_advance_to_next_step(): void
    {
        $contents = file_get_contents(resource_path('views/products/hotstrap_show.blade.php'));

        $this->assertStringContainsString('function advanceReadyGroupFromInput(input)', $contents);
        $this->assertStringContainsString("input.addEventListener('click', function()", $contents);
        $this->assertStringContainsString("this.dataset.changedSinceClick = '0';", $contents);
        $this->assertStringContainsString("this.dataset.changedSinceClick === '1'", $contents);
        $this->assertStringContainsString('advanceReadyGroupFromInput(this);', $contents);
    }
}
