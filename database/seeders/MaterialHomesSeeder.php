<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialHomesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('material_homes')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `material_homes` (`material_home_id`, `material_id`, `title`, `description`, `image_path`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 3, 'Rubber & PVC', 'Efeito 2D em relevo de alta qualidade, ideal para chaveiros, straps e descansos de copo.', 'material-homes/pEIdF4OTOdsJJ4rrnCgo7SuGYv6msqVPuYpZI5oz.png', 1, 1, '2026-05-12 22:14:25', '2026-05-12 22:14:25'),
(2, 4, 'Acrylic', 'Acrílico premium com acabamento transparente, colorido ou aurora para figuras incríveis.', 'material-homes/sEOk2Ppgz14tDw1qwN64paC9r34xa07YfAb03Kdt.png', 1, 2, '2026-05-12 22:15:00', '2026-05-12 22:15:00'),
(3, 5, 'Textile', 'Tecidos tecidos intrincados para amuletos tradicionais e tapeçarias de alta qualidade.', 'material-homes/XUnkIDclsOhg0q7xvQXejeRhGFm5ousO0CO2sn24.png', 1, 3, '2026-05-12 22:15:53', '2026-05-12 22:15:53'),
(4, 6, 'Polyester', 'Cordões de tecido duráveis, a escolha confiável para uso profissional diário.', 'material-homes/FUkivonIxbGY5S8LMIH29k1iC51UVKq7P07xPfhJ.png', 1, 4, '2026-05-12 22:16:14', '2026-05-12 22:16:14'),
(5, 7, 'Sublimation', 'Impressão digital colorida vibrante em cordões macios e de toque suave.', 'material-homes/gzl2SypXhjgaQlHn6IJ3eVtWNbb8UHLNXJqPkpoQ.png', 1, 5, '2026-05-12 22:16:37', '2026-05-12 22:16:37'),
(6, 8, 'Nylon', 'Acabamento brilhante luxuoso com resistência premium e visual sofisticado.', 'material-homes/caJYGMzh9m001kjGWAfAtZPT5sniz5VJdet459d3.png', 1, 6, '2026-05-12 22:16:59', '2026-05-12 22:16:59');
SQL);
    }
}
