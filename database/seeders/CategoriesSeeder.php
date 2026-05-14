<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `categories` (`category_id`, `category_name`, `image_path`, `sort_order`, `category_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Chaveiros', 'categories/hDh7PcBytDBbZas1eO9Qc6Pd8d4wdOd85q9d2Bdm.png', 2, 'c_01', 1, '2026-05-04 17:26:03', '2026-05-07 01:19:25'),
(2, 'Descansos de Copo', 'categories/7sK5aFZOF5DLO5rNmAozXZmtB8JOKWtrvISwy9dB.png', 1, 'd_01', 1, '2026-05-04 17:26:20', '2026-05-07 01:19:45'),
(3, 'Cordões', 'categories/pkC9IgVpiqMzbfbns0E2sl8x3gZHjIqgwLXhycqv.png', 3, 'c_02', 1, '2026-05-05 11:20:19', '2026-05-07 01:19:52'),
(4, 'Standees  e Figuras', 'categories/RY06pqr98xQ8c7CQMgQvb0E1tS5vNtR9Ulk6tKYS.png', 4, 's01', 1, '2026-05-05 11:20:36', '2026-05-07 01:20:01'),
(5, 'Acessórios e  Componentes', 'categories/7IlXcXL235Va9cK0hGDUOrzzDFEBgYUr9Veuhw3B.png', 5, 'a02', 1, '2026-05-05 11:21:09', '2026-05-07 01:20:10'),
(6, 'Omamori  e Decoração', 'categories/IOkVlvRAldM2OQHJGU8N8tzmJZrus4eN0U8aapW1.png', 6, 'o01', 1, '2026-05-05 11:21:24', '2026-05-07 01:20:18');
SQL);
    }
}
