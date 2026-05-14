<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionImagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('option_images')->truncate();

        DB::unprepared(<<<'SQL'
INSERT INTO `option_images` (`image_id`, `option_id`, `image_path`, `image_alt`, `is_main`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'options/yei4oo2nRVPoOIMf6acg0oBYGztPqKsNSCNKY7A4.png', 'Standard', 1, 1, '2026-05-07 00:16:35', '2026-05-07 00:16:35'),
(2, 2, 'options/bTMFDLHBCqD8A012n1wZhaxjlkxKs39SIdgk2hef.png', 'Front Keeper', 1, 1, '2026-05-07 00:16:55', '2026-05-07 00:16:55'),
(3, 11, 'options/wIHYIvt1u9o4LMDYesqefHRUFmruEFrsmT9GEERL.png', 'Hook (N-1)', 1, 1, '2026-05-07 00:39:33', '2026-05-07 00:39:33'),
(4, 12, 'options/tkaE7srdIBZqhYPlMrTtVBfI470w4h2y9JLQf7oa.png', 'Hook (N-14)', 1, 1, '2026-05-07 00:39:55', '2026-05-07 00:39:55'),
(5, 13, 'options/SjkJoqQBoWxqMSkFJREOAWIIDajfOkHujClT1rCP.png', 'O-ring', 1, 1, '2026-05-07 00:41:29', '2026-05-07 00:41:29'),
(6, 14, 'options/arqH77VN9qFL7HspevRVpFtySeqTTpEbOKoi6vYz.png', 'Hook (N-4)', 1, 1, '2026-05-07 00:41:52', '2026-05-07 00:41:52'),
(7, 15, 'options/F8EkNuVcJa40YRXKtknG7z9wCQgb1RlYjVUl0gJu.png', 'Plastic Hook (N-12)', 1, 1, '2026-05-07 00:42:12', '2026-05-07 00:42:12'),
(8, 16, 'options/D2RZtvJJ9D5zSgKLpca967nwQqrh30M6lf76yaDs.png', 'Phone  Attachment', 1, 1, '2026-05-07 00:45:53', '2026-05-07 00:45:53'),
(9, 17, 'options/I4oj1dQkc8G7WjxGlrY7HTKrwUqMb6k1zVrYIeFU.png', 'Safety  Breakaway', 1, 1, '2026-05-07 00:46:07', '2026-05-07 00:46:07'),
(10, 18, 'options/PcfZKLjEBygYjr8awoCtLlOk54kabDpSyea5GPoJ.png', 'Plastic Buckle', 1, 1, '2026-05-07 00:46:21', '2026-05-07 00:46:21'),
(11, 19, 'options/QqjXNRxIPEcLR7csRZggPee54He96WNycKz6tFaC.png', 'Badge Reel', 1, 1, '2026-05-07 00:48:13', '2026-05-07 00:48:13'),
(12, 20, 'options/wJLZe5Kh9r0rb019JMNVtEtc9LFMACe3eXr6UHm4.png', 'Carabiner  Badge Reel', 1, 1, '2026-05-07 00:49:44', '2026-05-07 00:49:44'),
(13, 21, 'options/Gx28TB0BD9bKfYCO8lOh1icAnjEk3i8PygnBgenr.png', 'Soft ID Card Holder 6_N', 1, 1, '2026-05-07 00:56:56', '2026-05-07 00:56:56'),
(14, 22, 'options/80ChIsCy8Z0rZyGG5kmstrJrWzudlXpYQo8V4PS0.png', 'Soft ID Card Holder 7_N', 1, 1, '2026-05-07 00:57:46', '2026-05-07 00:57:46'),
(15, 40, 'options/knDkLNFJdrfreQ9k477E42tSZsXT5DTWUIBXs6M0.jpg', 'tipo lagosta', 1, 1, '2026-05-12 19:22:45', '2026-05-12 19:22:45'),
(16, 41, 'options/2cFD3WlUq1sJFhw9yY3WR7j68dgIK8LiJyjTGtvA.jpg', 'Gancho de pressão prateado', 1, 1, '2026-05-12 19:24:07', '2026-05-12 19:24:07'),
(17, 42, 'options/hMjH10h81y5wYP0pXl1yvwwj1vSyZoXMGk7hl4IY.jpg', 'gancho de pressão dourado', 1, 1, '2026-05-12 19:24:58', '2026-05-12 19:24:58'),
(18, 43, 'options/GlvDYgkHfGaBO90fZXfsD42FbF6nSTfhn3qCplPW.webp', 'Abridor de garrafas (preto)', 1, 1, '2026-05-12 19:25:58', '2026-05-12 19:25:58'),
(19, 46, 'options/47bqhylFNIdyYpO18wSG87VRutJPr2OzLDsdfzW1.jpg', 'padrão de papel A-1', 1, 1, '2026-05-12 19:35:10', '2026-05-12 19:35:10'),
(20, 47, 'options/cEE8PwdKGvgYuwhBDYhUDDCLHSqRIFypBnEDaqAP.jpg', 'padrão de papel A-2', 1, 1, '2026-05-12 19:36:09', '2026-05-12 19:36:09'),
(21, 48, 'options/jO14l0CJInhJRefJP9vA9ERmmxlsM30MHXQwYqpc.jpg', 'none', 1, 1, '2026-05-12 19:36:26', '2026-05-12 19:36:26');
SQL);
    }
}
