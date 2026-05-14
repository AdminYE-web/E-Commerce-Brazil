<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSubmissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contact_submissions')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `contact_submissions` (`id`, `contact_method`, `subject`, `name`, `email`, `line_id`, `country_code`, `phone`, `message`, `attachment_path`, `attachment_original_name`, `ip_address`, `created_at`, `updated_at`) VALUES
(5, 'whatsapp', 'quote', 'Ome', 'webadmin@youandearth-th.com', NULL, '+81', '0888888888', 'Test message from TH', NULL, NULL, '180.180.232.246', '2026-05-13 00:36:14', '2026-05-13 00:36:14');
SQL);
    }
}
