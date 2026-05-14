<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPriceTiersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_price_tiers')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_price_tiers` (`tier_id`, `product_id`, `min_qty`, `max_qty`, `unit_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 200.00, 1, '2026-05-07 00:33:26', '2026-05-07 00:33:26'),
(2, 1, 6, 10, 100.00, 1, '2026-05-07 00:33:26', '2026-05-07 01:06:11');
SQL);
    }
}
