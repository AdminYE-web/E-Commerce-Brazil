<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materials')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `materials` (`material_id`, `material_name`, `material_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Borracha', 'b_01', 1, '2026-05-04 17:26:46', '2026-05-04 17:26:46'),
(2, 'Acrílico', 'a_01', 1, '2026-05-04 17:26:57', '2026-05-04 17:27:02'),
(3, 'Rubber & PVC', 'Rubber & PVC', 1, '2026-05-12 22:13:15', '2026-05-12 22:13:15'),
(4, 'Acrylic', 'Acrylic', 1, '2026-05-12 22:13:22', '2026-05-12 22:13:22'),
(5, 'Textile', 'Textile', 1, '2026-05-12 22:13:28', '2026-05-12 22:13:28'),
(6, 'Polyester', 'Polyester', 1, '2026-05-12 22:13:35', '2026-05-12 22:13:35'),
(7, 'Sublimation', 'Sublimation', 1, '2026-05-12 22:13:41', '2026-05-12 22:13:41'),
(8, 'Nylon', 'Nylon', 1, '2026-05-12 22:13:47', '2026-05-12 22:13:47');
SQL);
    }
}
