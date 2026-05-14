<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductListBannersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_list_banners')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_list_banners` (`banner_id`, `title`, `subtitle`, `image_path`, `link_url`, `button_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'product banner', 'product banner', 'product-list-banners/0EjVDUpdbNQHpD9hmmm8yzFTf5rov9kFhitZvYhS.png', NULL, NULL, 0, 1, '2026-05-12 22:10:46', '2026-05-12 22:11:33');
SQL);
    }
}
