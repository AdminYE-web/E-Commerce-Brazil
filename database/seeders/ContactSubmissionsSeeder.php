<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSubmissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contact_submissions')->truncate();

        $now = now();

        DB::table('contact_submissions')->insert([
            [
                'contact_method' => 'whatsapp',
                'subject' => 'quote',
                'name' => 'Maria Santos',
                'email' => 'maria.santos@example.com',
                'line_id' => null,
                'country_code' => '+55',
                'phone' => '+55 11 98888-1234',
                'message' => 'Gostaria de receber um orcamento para 300 cordoes personalizados com logo colorido.',
                'attachment_path' => null,
                'attachment_original_name' => null,
                'ip_address' => '203.0.113.10',
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(8),
            ],
            [
                'contact_method' => 'line',
                'subject' => 'support',
                'name' => 'Kenji Tanaka',
                'email' => 'kenji.tanaka@example.jp',
                'line_id' => 'kenji_tanaka',
                'country_code' => '+81',
                'phone' => '+81 90-1234-5678',
                'message' => 'Preciso confirmar as opcoes de material antes de finalizar meu pedido.',
                'attachment_path' => null,
                'attachment_original_name' => null,
                'ip_address' => '198.51.100.24',
                'created_at' => $now->copy()->subDays(6),
                'updated_at' => $now->copy()->subDays(6),
            ],
            [
                'contact_method' => 'phone',
                'subject' => 'payment',
                'name' => 'Ana Oliveira',
                'email' => 'ana.oliveira@example.com',
                'line_id' => null,
                'country_code' => '+81',
                'phone' => '+81 80-2222-3333',
                'message' => 'Tenho duvidas sobre formas de pagamento e prazo para confirmacao.',
                'attachment_path' => null,
                'attachment_original_name' => null,
                'ip_address' => '203.0.113.42',
                'created_at' => $now->copy()->subDays(4),
                'updated_at' => $now->copy()->subDays(4),
            ],
            [
                'contact_method' => 'whatsapp',
                'subject' => 'order',
                'name' => 'Rafael Costa',
                'email' => 'rafael.costa@example.com',
                'line_id' => null,
                'country_code' => '+55',
                'phone' => '+55 21 97777-4567',
                'message' => 'Quero verificar o status de um pedido feito na semana passada.',
                'attachment_path' => null,
                'attachment_original_name' => null,
                'ip_address' => '198.51.100.87',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'contact_method' => 'line',
                'subject' => 'quote',
                'name' => 'Yumi Nakamura',
                'email' => 'yumi.nakamura@example.jp',
                'line_id' => 'yumi_naka',
                'country_code' => '+81',
                'phone' => '+81 70-4444-5555',
                'message' => 'Por favor envie uma cotacao para porta-cracha com arte personalizada.',
                'attachment_path' => 'contact-attachments/sample-logo.pdf',
                'attachment_original_name' => 'sample-logo.pdf',
                'ip_address' => '203.0.113.88',
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ],
        ]);
    }
}
