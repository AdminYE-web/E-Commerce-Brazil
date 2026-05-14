<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeBannersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('home_banners')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `home_banners` (`home_banner_id`, `title`, `link_url`, `image_pc`, `image_mobile`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'banner1', NULL, 'home-banners/pc/ovS51BRDTuvKsXna0uhbdUuLZkSqDfKrS9ATJm1T.png', 'home-banners/mobile/L6XZiTnYSZEAGMjfJIVCARtyLWxhGkZ5mTECz4gx.png', 1, 0, '2026-05-12 22:06:02', '2026-05-12 22:06:02'),
(2, 'banner2', NULL, 'home-banners/pc/OsKjkxNnz1dSFYA1WQH6HoBDr837SBA7h0RFZS1I.png', 'home-banners/mobile/epYCA50hyNbbWZ7DnKUy1Mq9wQSTdsPnRCrMtqKq.png', 1, 2, '2026-05-12 22:06:26', '2026-05-12 22:06:26');
SQL);
    }
}
