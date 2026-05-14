<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_images')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `product_images` (`image_id`, `product_id`, `image_path`, `image_alt`, `image_type`, `is_main`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/fz4RDzwXsudnmrzjXncmfLjp2tVNBrAlZvPezFeC.png', 'Polyester', 'main', 1, 1, '2026-05-06 01:29:01', '2026-05-12 22:12:05'),
(2, 1, 'products/gallery/t7qCKZeZf8TFBywMT2NhrKERuZLrKLwHAJb0WujT.png', 'Polyester', 'gallery', 0, 1, '2026-05-06 01:29:01', '2026-05-12 22:12:05'),
(3, 1, 'products/gallery/VQSpf0y0mLdKw7PCwQPOJPibYsILkjE7COXpOTb1.png', 'Polyester', 'gallery', 0, 2, '2026-05-06 01:29:01', '2026-05-12 22:12:05'),
(4, 1, 'products/gallery/rP3iEMcOBAGxezr3KTOc1KnkYRM9yUvxp6GLp8nc.png', 'Polyester', 'gallery', 0, 3, '2026-05-06 01:29:01', '2026-05-12 22:12:05'),
(5, 1, 'products/2kiPCkbQCgFrpIcjmm6LnkwCAyCCAJVCdRH1zMh9.png', 'Cordão, de Poliester  Personalizado', 'main', 0, 4, '2026-05-06 23:34:47', '2026-05-12 22:12:05'),
(6, 1, 'products/gallery/0zMM4cl8v32aDsOBtejwPYC5GyRAbqzJ9A3kIevy.png', 'Cordão, de Poliester  Personalizado', 'gallery', 0, 4, '2026-05-06 23:34:47', '2026-05-12 22:12:05'),
(7, 1, 'products/gallery/XiVPtbUImtzohh6YunQPZdRM1ZG9awDQaD7YUxUz.png', 'Cordão, de Poliester  Personalizado', 'gallery', 0, 5, '2026-05-06 23:34:47', '2026-05-12 22:12:05'),
(8, 1, 'products/gallery/DBKvzbkQZT3DRtN3BB6cnntCCA3Ze3WaQv4an6R8.png', 'Cordão, de Poliester  Personalizado', 'gallery', 0, 6, '2026-05-06 23:34:47', '2026-05-12 22:12:05'),
(13, 3, 'products/vSyyIOmueiNJJ7PXa26Kgslh3qmM4xt9AvlQGJ48.webp', 'Chaveiros de acrílico', 'main', 1, 1, '2026-05-08 00:21:59', '2026-05-12 22:12:00'),
(14, 3, 'products/gallery/GzsC6cM8XZvr0vWU3dke13EMK4Sp500y5qxyqys9.webp', 'Chaveiros de acrílico', 'gallery', 0, 1, '2026-05-08 00:21:59', '2026-05-12 22:12:00'),
(15, 3, 'products/gallery/HZ1izAEStrRNHMteJzQPNVtYeT6UT5R1UxSiB28O.webp', 'Chaveiros de acrílico', 'gallery', 0, 2, '2026-05-08 00:21:59', '2026-05-12 22:12:00'),
(16, 3, 'products/gallery/xzHiWYMCEY5CllDIlGyVdztzUm2Ytl1N3y3r9AvQ.webp', 'Chaveiros de acrílico', 'gallery', 0, 3, '2026-05-08 00:21:59', '2026-05-12 22:12:00'),
(17, 3, 'products/gallery/G3s968kL6lqhKfN24oh4wDreBZAEgB6JquUbEIkD.webp', 'Chaveiros de acrílico', 'gallery', 0, 4, '2026-05-08 00:21:59', '2026-05-12 22:12:00'),
(18, 3, 'products/gallery/kBb4YBlqCQWBGbkH0bzdLz3VHC9BcphMFV5udpmP.webp', 'Chaveiros de acrílico', 'gallery', 0, 5, '2026-05-08 00:21:59', '2026-05-12 22:12:00');
SQL);
    }
}
