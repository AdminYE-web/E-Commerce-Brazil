<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_options')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_options` (`option_id`, `option_group_id`, `option_code`, `option_name`, `color_code`, `option_detail`, `additional_price`, `price_type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 's01', 'Standard', NULL, NULL, 10.00, 'per_item', 1, '2026-05-07 00:16:35', '2026-05-07 00:16:35'),
(2, 1, 's02', 'Front Keeper', NULL, NULL, 20.00, 'per_item', 1, '2026-05-07 00:16:55', '2026-05-07 00:18:17'),
(3, 2, '10mm', '10 mm', NULL, NULL, 10.00, 'per_item', 1, '2026-05-07 00:25:38', '2026-05-07 00:25:38'),
(4, 2, '15 mm', '15 mm', NULL, NULL, 15.00, 'per_item', 1, '2026-05-07 00:26:09', '2026-05-07 00:26:09'),
(5, 2, '20mm', '20 mm', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:26:26', '2026-05-07 00:26:26'),
(6, 3, 'r1', '#D20000', '#D20000', NULL, 0.00, 'per_item', 1, '2026-05-07 00:31:50', '2026-05-07 00:31:50'),
(7, 3, '#12A60D', '#12A60D', '#12A60D', NULL, 0.00, 'per_item', 1, '2026-05-07 00:32:06', '2026-05-07 00:32:06'),
(8, 3, '#1A0581', '#1A0581', '#1A0581', NULL, 0.00, 'per_item', 1, '2026-05-07 00:32:19', '2026-05-07 00:32:19'),
(9, 4, 'd01', 'Don’t need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:35:57', '2026-05-07 00:35:57'),
(10, 4, 'n02', 'Need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:36:16', '2026-05-07 00:36:16'),
(11, 5, 'Hook (N-1)', 'Hook (N-1)', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:39:33', '2026-05-07 00:39:33'),
(12, 5, 'Hook (N-14)', 'Hook (N-14)', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:39:55', '2026-05-07 00:39:55'),
(13, 5, 'O-ring', 'O-ring', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:41:29', '2026-05-07 00:41:29'),
(14, 5, 'Hook (N-4)', 'Hook (N-4)', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:41:52', '2026-05-07 00:41:52'),
(15, 5, 'Plastic Hook (N-12)', 'Plastic Hook (N-12)', NULL, NULL, 20.00, 'per_item', 1, '2026-05-07 00:42:12', '2026-05-07 00:42:12'),
(16, 6, 'Phone  Attachment', 'Phone  Attachment', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:45:53', '2026-05-07 00:45:53'),
(17, 6, 'Safety  Breakaway', 'Safety  Breakaway', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:46:07', '2026-05-07 00:46:07'),
(18, 6, 'Plastic Buckle', 'Plastic Buckle', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:46:21', '2026-05-07 00:46:21'),
(19, 7, 'Badge Reel', 'Badge Reel', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:48:13', '2026-05-07 00:48:13'),
(20, 7, 'Carabiner  Badge Reel', 'Carabiner  Badge Reel', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:49:44', '2026-05-07 00:49:44'),
(21, 8, 'Soft ID Card Holder 6_N', 'Soft ID Card Holder 6_N', NULL, 'Model: ID-6_N\r\nType: Soft Card Holder\r\nCard Size: 91 mm (H) × 55 mm (W)\r\nOuter Size: 113 mm (H) × 66 mm (W)\r\nOrientation: Vertical card insertion\r\nColor: Clear / Transparent (Front & Back)\r\nCover & Zipper: None\r\nSide Holes (Left–Right): Diameter 4.4 mm\r\nCenter Slot: 17 mm (W) × 4.4 mm (H)', 0.00, 'per_item', 1, '2026-05-07 00:56:56', '2026-05-07 00:56:56'),
(22, 8, 'Soft ID Card Holder 7_N', 'Soft ID Card Holder 7_N', NULL, 'Model: ID-7_N\r\nType: Soft Card Holder\r\nCard Size: 91 mm (H) × 55 mm (W)\r\nOuter Size: 113 mm (H) × 66 mm (W)\r\nOrientation: Vertical card insertion\r\nColor: Clear / Transparent (Front & Back)\r\nCover & Zipper: None\r\nSide Holes (Left–Right): Diameter 4.4 mm\r\nCenter Slot: 17 mm (W) × 4.4 mm (H)', 20.00, 'per_item', 1, '2026-05-07 00:57:46', '2026-05-07 00:57:46'),
(23, 9, 't01', 'Two Side Printed', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:58:51', '2026-05-07 00:58:51'),
(24, 9, 'o01', 'One Side Printed', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 00:59:03', '2026-05-07 00:59:03'),
(25, 11, 'n02', 'Don’t need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 01:01:34', '2026-05-07 01:01:34'),
(26, 11, 'n03', 'Need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 01:01:46', '2026-05-07 01:01:46'),
(27, 12, 'n03', 'Don’t need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 01:02:04', '2026-05-07 01:02:04'),
(28, 12, 'n04d', 'Need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 01:02:17', '2026-05-07 01:02:17'),
(29, 13, 'anti_v2', 'Need', NULL, 'Lorem', 50.00, 'per_item', 1, '2026-05-07 17:17:25', '2026-05-07 17:17:25'),
(30, 13, 'anti_v2s', 'No need', NULL, NULL, 0.00, 'per_item', 1, '2026-05-07 17:17:44', '2026-05-07 17:17:44'),
(31, 14, 'size_50', '50mm', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:46:45', '2026-05-08 00:46:45'),
(32, 14, 'size_75', '75mm', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:47:20', '2026-05-08 00:47:20'),
(33, 14, 'size_100', '100mm', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:47:32', '2026-05-08 00:47:32'),
(34, 15, 'acrylic_screen_single', 'Impressão em um só lado', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:50:51', '2026-05-08 00:50:51'),
(35, 15, 'acrylic_screen_double', 'Impressão frente e verso', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:51:19', '2026-05-08 00:51:19'),
(36, 16, 'acrylic_order_standard', '10 dias úteis', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:53:27', '2026-05-08 00:53:27'),
(37, 16, 'acrylic_order_rush', '6 dias úteis', NULL, NULL, 0.00, 'per_item', 1, '2026-05-08 00:53:54', '2026-05-08 00:53:54'),
(38, 17, 'es01', 'não', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:04:07', '2026-05-12 19:04:07'),
(39, 17, 'es02', 'sim', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:04:33', '2026-05-12 19:04:33'),
(40, 18, 't1', 'tipo lagosta', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:22:45', '2026-05-12 19:22:45'),
(41, 18, 't2', 'Gancho de pressão prateado', NULL, NULL, 11.00, 'per_item', 1, '2026-05-12 19:24:07', '2026-05-12 19:25:17'),
(42, 18, 'g01', 'gancho de pressão dourado', NULL, NULL, 12.00, 'per_item', 1, '2026-05-12 19:24:58', '2026-05-12 19:24:58'),
(43, 18, NULL, 'Abridor de garrafas (preto)', NULL, NULL, 55.00, 'per_item', 1, '2026-05-12 19:25:58', '2026-05-12 19:25:58'),
(44, 19, 'p01', 'pode ser', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:32:54', '2026-05-12 19:32:54'),
(45, 19, 'e01', 'É impossível.', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:33:22', '2026-05-12 19:33:22'),
(46, 20, 'a1', 'padrão de papel A-1', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:35:10', '2026-05-12 19:35:44'),
(47, 20, 'a2', 'padrão de papel A-2', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:36:09', '2026-05-12 19:36:09'),
(48, 20, 'no', 'none', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:36:26', '2026-05-12 19:36:26'),
(49, 21, 'yss', 'sim', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:46:02', '2026-05-12 19:46:02'),
(50, 21, 'n02', 'não', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:46:22', '2026-05-12 19:46:22'),
(51, 22, NULL, 'sim', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:49:32', '2026-05-12 19:49:32'),
(52, 22, NULL, 'não', NULL, NULL, 0.00, 'per_item', 1, '2026-05-12 19:49:44', '2026-05-12 19:49:44');
SQL);
    }
}
