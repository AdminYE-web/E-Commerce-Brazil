<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialAccountsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('social_accounts')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `social_accounts` (`social_account_id`, `user_id`, `provider`, `provider_id`, `provider_email`, `provider_name`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 1, 'google', '113126492769182275802', 'webadmin@youandearth-th.com', 'Web Admin You and earth (Thailand)', 'https://lh3.googleusercontent.com/a/ACg8ocIY_ty78aUJsFg24rtsQ9oDx3d_LV133jt9MBhRTwexLY17Lg=s96-c', '2026-05-10 17:52:17', '2026-05-10 17:52:17');
SQL);
    }
}
