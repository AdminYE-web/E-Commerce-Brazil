<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminContactSubmissionsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_can_view_contact_submission_list(): void
    {
        $admin = $this->adminUser();

        ContactSubmission::create([
            'contact_method' => 'whatsapp',
            'subject' => 'quote',
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'country_code' => '+55',
            'phone' => '+55 11 98888-1234',
            'message' => 'Please send a quotation for custom lanyards.',
            'ip_address' => '203.0.113.10',
        ]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.contact-submissions.index'));

        $response
            ->assertOk()
            ->assertSee('Contact Submissions')
            ->assertSee('Maria Santos')
            ->assertSee('maria@example.com')
            ->assertSee('quote');
    }

    public function test_admin_can_view_contact_submission_detail(): void
    {
        $admin = $this->adminUser();

        $submission = ContactSubmission::create([
            'contact_method' => 'line',
            'subject' => 'support',
            'name' => 'Kenji Tanaka',
            'email' => 'kenji@example.jp',
            'line_id' => 'kenji_line',
            'country_code' => '+81',
            'phone' => '+81 90-1234-5678',
            'message' => 'I need help confirming the best material option.',
            'attachment_path' => 'contact-attachments/sample-logo.pdf',
            'attachment_original_name' => 'sample-logo.pdf',
            'ip_address' => '198.51.100.24',
        ]);

        $response = $this
            ->actingAs($admin, 'admin')
            ->get(route('admin.contact-submissions.show', $submission));

        $response
            ->assertOk()
            ->assertSee('Kenji Tanaka')
            ->assertSee('kenji@example.jp')
            ->assertSee('kenji_line')
            ->assertSee('I need help confirming the best material option.')
            ->assertSee('sample-logo.pdf');
    }

    private function adminUser(): AdminUser
    {
        return AdminUser::create([
            'name' => 'Admin User',
            'email' => 'admin-contact-'.uniqid().'@example.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
            'is_active' => 1,
        ]);
    }
}
