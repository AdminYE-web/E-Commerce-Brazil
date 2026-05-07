<?php

namespace Tests\Feature;

use Tests\TestCase;

class LanguageSwitcherTest extends TestCase
{
    public function test_default_locale_is_portuguese_when_no_language_is_selected(): void
    {
        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('<html lang="pt">', false);
    }

    public function test_it_switches_to_each_supported_language(): void
    {
        foreach (['pt', 'ja', 'en'] as $locale) {
            $response = $this->from('/contact')->get("/language/{$locale}");

            $response->assertRedirect('/contact');
            $response->assertSessionHas('locale', $locale);
        }
    }

    public function test_it_switches_to_japanese(): void
    {
        $response = $this->from('/contact')->get('/language/ja');

        $response->assertRedirect('/contact');
        $response->assertSessionHas('locale', 'ja');
    }

    public function test_japanese_locale_renders_translated_contact_page(): void
    {
        $response = $this->withSession(['locale' => 'ja'])->get('/contact');

        $response->assertOk();
        $response->assertSee('<html lang="ja">', false);
        $response->assertSee('お問い合わせ');
        $response->assertSee('日本語 (JP)');
    }

    public function test_selected_locale_persists_between_pages(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get('/contact/complete');

        $response->assertOk();
        $response->assertSee('<html lang="en">', false);
        $response->assertSee('Thank you!');
    }

    public function test_invalid_locale_does_not_replace_current_locale(): void
    {
        $response = $this->withSession(['locale' => 'ja'])
            ->from('/contact')
            ->get('/language/es');

        $response->assertRedirect('/contact');
        $response->assertSessionHas('locale', 'ja');
    }
}
