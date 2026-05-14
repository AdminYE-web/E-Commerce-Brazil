<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionDependenciesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('option_dependencies')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `option_dependencies` (`dependency_id`, `parent_option_id`, `target_type`, `target_group_id`, `target_option_id`, `child_option_id`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 13, 'option', NULL, 24, 24, 1, 0, '2026-05-08 00:37:17', NULL),
(2, 13, 'option', NULL, 24, 24, 1, 0, '2026-05-08 00:37:17', NULL),
(3, 44, 'group', 20, NULL, NULL, 1, 0, '2026-05-12 19:43:08', '2026-05-12 19:43:08');
SQL);
    }
}
