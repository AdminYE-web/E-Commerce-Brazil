<?php

namespace Tests\Feature;

use Tests\TestCase;

class HeaderLogoTest extends TestCase
{
    public function test_header_renders_logo_image(): void
    {
        $response = $this->get('/contact');

        $response->assertOk();
        $response->assertSee('src="' . asset('assets/images/home/logo.png') . '"', false);
    }
}
