<?php

namespace Tests\Feature;

use App\Mail\ContactFormSubmitted;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_dev_cookie_renders_contact_form_without_recaptcha_gate(): void
    {
        $response = $this
            ->withUnencryptedCookie('dev', '1')
            ->get(route('contact'));

        $response
            ->assertOk()
            ->assertDontSee('g-recaptcha', false)
            ->assertDontSee('https://www.google.com/recaptcha/api.js', false)
            ->assertSee('class="contact-submit" type="submit"', false)
            ->assertDontSee('class="contact-submit" type="submit" disabled', false);
    }

    public function test_dev_cookie_bypasses_recaptcha_verification(): void
    {
        Mail::fake();

        $response = $this
            ->withCredentials()
            ->withUnencryptedCookie('dev', '1')
            ->postJson(route('contact.submit'), [
                'contact_method' => 'whatsapp',
                'subject' => 'quote',
                'name' => 'Dev Tester',
                'email' => 'dev@example.com',
                'country_code' => '+55',
                'phone' => '+55 11 99999-9999',
                'message' => 'This message is long enough for the contact form.',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('redirect', route('contact.complete'));

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'dev@example.com',
            'subject' => 'quote',
        ]);

        Mail::assertSent(ContactFormSubmitted::class, function (ContactFormSubmitted $mail) {
            return $mail->submission->email === 'dev@example.com';
        });
    }
}
