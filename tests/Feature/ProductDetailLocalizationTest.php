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
}
