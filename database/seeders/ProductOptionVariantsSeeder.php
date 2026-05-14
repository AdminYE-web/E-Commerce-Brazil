<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionVariantsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_option_variants')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_option_variants` (`variant_id`, `option_id`, `variant_name`, `color_code`, `image_path`, `additional_price`, `sort_order`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 19, 'black', NULL, 'product-option-variants/spPUmZdFbGjwQRAOqYiQKjKA3lrwh82lK6zJOGKQ.png', 0.00, 1, 1, 1, '2026-05-07 00:48:48', '2026-05-07 00:48:48'),
(2, 19, 'white', NULL, 'product-option-variants/Vec79zm2SPBReWhJ1x47Be0u9NScVdURJB8NpAIv.png', 0.00, 2, 0, 1, '2026-05-07 00:49:05', '2026-05-07 00:49:05'),
(3, 20, 'white', NULL, 'product-option-variants/8vc2IEBBpqze6n02ZKN1mBz11uuolxAmoaValfq8.png', 0.00, 1, 1, 1, '2026-05-07 00:50:03', '2026-05-07 00:50:03'),
(4, 20, 'black', NULL, 'product-option-variants/2WsuudUqpWDt4f3Nah6evvgdJp3QNSO3ovePK1N3.png', 0.00, 2, 0, 1, '2026-05-07 00:54:04', '2026-05-07 00:54:04');
SQL);
    }
}
