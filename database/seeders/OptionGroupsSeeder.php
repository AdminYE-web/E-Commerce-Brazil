<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionGroupsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('option_groups')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `option_groups` (`option_group_id`, `parent_group_id`, `group_code`, `group_name`, `display_type`, `help_text`, `is_required`, `option_group_main`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'c01', 'Estilo do Cordão', 'image_card', NULL, 1, 0, 1, 1, '2026-05-07 00:15:57', '2026-05-07 00:29:47'),
(2, NULL, 'l01', 'Largura do Cordão', 'button', NULL, 1, 0, 2, 1, '2026-05-07 00:24:54', '2026-05-07 00:29:40'),
(3, NULL, 'c012', 'Cores do Cordão', 'color', NULL, 1, 0, 3, 1, '2026-05-07 00:29:30', '2026-05-07 00:29:30'),
(4, NULL, 'Cores Especiais do Cordão', 'Cores Especiais do Cordão', 'button', NULL, 1, 0, 4, 1, '2026-05-07 00:35:18', '2026-05-07 00:55:43'),
(5, NULL, 'Ganchos / Acessórios', 'Ganchos / Acessórios', 'image_grid_compact', NULL, 1, 0, 5, 1, '2026-05-07 00:38:02', '2026-05-07 00:55:50'),
(6, NULL, 'Upgrades Adicionais no Cordão', 'Upgrades Adicionais no Cordão', 'image_grid_compact', NULL, 1, 0, 6, 1, '2026-05-07 00:44:46', '2026-05-07 00:44:46'),
(7, NULL, 'Opções de Porta-Crachá Retrátil (Yoyo)', 'Opções de Porta-Crachá Retrátil (Yoyo)', 'image_card_variant', NULL, 1, 0, 7, 1, '2026-05-07 00:47:07', '2026-05-07 00:55:15'),
(8, NULL, 'Protetores de Crachá', 'Protetores de Crachá', 'select_detail', NULL, 1, 0, 8, 1, '2026-05-07 00:56:22', '2026-05-07 00:56:22'),
(9, NULL, 'Opções de Impressão no Cordão', 'Opções de Impressão no Cordão', 'button', NULL, 1, 0, 9, 1, '2026-05-07 00:58:09', '2026-05-07 00:58:09'),
(10, NULL, 'Detalhes Adicionais', 'Detalhes Adicionais', 'grouped_buttons', NULL, 1, 0, 10, 1, '2026-05-07 00:59:58', '2026-05-07 01:03:16'),
(11, 10, 'd01', 'Do you require a prototype sample?', 'button', NULL, 1, 0, 0, 1, '2026-05-07 01:00:29', '2026-05-07 01:00:29'),
(12, 10, 'r01', 'Rush Order?', 'button', NULL, 1, 0, 0, 1, '2026-05-07 01:00:58', '2026-05-07 01:00:58'),
(13, NULL, 'ant_v1', 'Antivirus', 'button', NULL, 0, 1, 2, 1, '2026-05-07 17:16:02', '2026-05-07 17:16:02'),
(14, NULL, 'acrylic_size', 'Tamanho', 'button', NULL, 1, 1, 0, 1, '2026-05-08 00:46:11', '2026-05-12 19:16:46'),
(15, NULL, 'acrylic_screen', 'Superfície impressa', 'button', NULL, 1, 1, 4, 1, '2026-05-08 00:50:03', '2026-05-12 19:16:54'),
(16, NULL, 'acrylic_order_type', 'Prazo final', 'button', NULL, 1, 1, 2, 1, '2026-05-08 00:52:19', '2026-05-12 19:14:56'),
(17, NULL, 'prev01', 'Este modelo é o mesmo do seu pedido anterior?', 'previous_order_design', 'Este modelo é o mesmo do seu pedido anterior?', 1, 0, 1, 1, '2026-05-12 19:02:52', '2026-05-12 19:02:52'),
(18, NULL, 'anexo', 'anexo', 'image_grid_compact', NULL, 1, 0, 4, 1, '2026-05-12 19:18:00', '2026-05-12 19:18:00'),
(19, NULL, 's01', 'Suporte de papelão', 'button', NULL, 1, 0, 6, 1, '2026-05-12 19:31:26', '2026-05-12 19:38:35'),
(20, NULL, 'p002', 'Papel de suporte impresso', 'image_grid_compact', NULL, 1, 0, 7, 1, '2026-05-12 19:34:25', '2026-05-12 19:34:25'),
(21, NULL, 's011', 'Suporte para criação de protótipos e dados', 'button', NULL, 1, 0, 8, 1, '2026-05-12 19:45:33', '2026-05-12 19:45:33'),
(22, NULL, 'a03', 'Assistência na criação de dados', 'button', NULL, 1, 0, 9, 1, '2026-05-12 19:48:31', '2026-05-12 19:48:31');
SQL);
    }
}
