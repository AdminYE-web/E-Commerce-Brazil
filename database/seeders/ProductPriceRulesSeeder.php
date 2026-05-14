<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPriceRulesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_price_rules')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_price_rules` (`rule_id`, `product_id`, `rule_name`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 3, '50 + single + standard', 1, 1, '2026-05-08 01:06:54', '2026-05-08 01:06:54'),
(2, 3, '50 + double + standard', 1, 0, '2026-05-08 01:08:08', '2026-05-08 01:08:08'),
(3, 3, '50 + single + rush', 1, 0, '2026-05-08 01:11:32', '2026-05-08 01:11:32'),
(4, 3, '50 + double + rush', 1, 0, '2026-05-08 01:12:43', '2026-05-08 01:12:43');
SQL);
    }
}
