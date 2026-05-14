<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `products` (`product_id`, `product_code`, `category_id`, `material_id`, `product_type`, `product_name`, `description`, `is_antivirus_included`, `is_active`, `product_recomend`, `product_premium`, `can_upload_artwork`, `artwork_required`, `allow_no_artwork`, `allow_text_print`, `allow_font_select`, `allow_template_select`, `created_at`, `updated_at`) VALUES
(1, 'c01', 3, 1, 1, 'Cordão, de Poliester  Personalizado', 'Destaque sua marca com nossos cordões personalizados premium. > Totalmente customizáveis em cor, tamanho e acabamento, nossos cordões são ideais para empresas e eventos. Garantimos alta durabilidade e produção rápida para pedidos de 20 a 10.000  unidades. Oferecemos porta-crachás flexíveis gratuitos sob consulta. Qualidade e rapidez que seu evento merece!', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, '2026-05-06 01:29:01', '2026-05-12 22:12:05'),
(3, 'acrylic-keychains', 1, 2, 2, 'Chaveiros de acrílico', 'Nossos chaveiros são fabricados em acrílico transparente de alta qualidade, garantindo durabilidade e um acabamento brilhante impecável. Com impressão de alta definição e cores vibrantes, eles são o acessório perfeito para organizar suas chaves ou decorar sua mochila com estilo. Leves, resistentes e totalmente personalizáveis, são ideais para presentes exclusivos ou brindes corporativos sofisticados.', 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, '2026-05-08 00:21:59', '2026-05-12 22:12:00');
SQL);
    }
}
