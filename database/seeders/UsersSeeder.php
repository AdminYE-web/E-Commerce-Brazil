<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `name`, `email`, `phone`, `avatar`, `password`, `status`, `term_policy`, `receive_email`, `email_verified_at`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Web', 'Admin You and earth (Thailand)', 'Web Admin You and earth (Thailand)', 'webadmin@youandearth-th.com', NULL, NULL, NULL, '1', 1, 1, '2026-05-10 17:52:17', '2026-05-10 17:52:17', 'L7fE5NOD2LCvzdX7vj0E0oEaC6EFYrFODjfCvJhfNPwRZxCtVFOiuNSI98LP', '2026-05-10 17:52:17', '2026-05-10 17:52:17');
SQL);
    }
}
