<!DOCTYPE html>
<html lang="pt-BR" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Novo Contato Recebido</title>
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <style>
        /* ── Reset ── */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }

        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #eef1f5;
            color: #1a1a2e;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            width: 100%;
            background-color: #eef1f5;
            padding: 40px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(4, 63, 115, 0.08);
        }

        /* ── Header ── */
        .email-header {
            background: linear-gradient(135deg, #043f73 0%, #07559d 50%, #0876dd 100%);
            padding: 44px 40px 38px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0 0 6px;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.3px;
        }

        .email-header p {
            margin: 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 400;
        }

        .header-accent {
            display: block;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ffd200 0%, #ffb800 100%);
        }

        /* ── Body ── */
        .email-body {
            padding: 36px 40px 28px;
        }

        .greeting {
            font-size: 15px;
            color: #444466;
            line-height: 1.6;
            margin: 0 0 24px;
        }

        .greeting strong {
            color: #1a1a2e;
        }

        /* ── Detail Cards ── */
        .detail-section {
            margin-bottom: 24px;
        }

        .section-label {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            color: #043f73;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 0 0 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #ffd200;
        }

        .detail-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .detail-grid tr {
            transition: background 0.15s;
        }

        .detail-grid td {
            padding: 13px 16px;
            font-size: 14px;
            vertical-align: top;
            border-bottom: 1px solid #f0f2f5;
        }

        .detail-grid tr:last-child td {
            border-bottom: none;
        }

        .detail-grid .label-cell {
            width: 38%;
            color: #6b7280;
            font-weight: 600;
            font-size: 13px;
            background-color: #fafbfd;
            border-right: 1px solid #f0f2f5;
        }

        .detail-grid .value-cell {
            color: #1a1a2e;
            font-weight: 500;
        }

        .detail-card {
            background: #f8fafc;
            border: 1px solid #e8ecf1;
            border-radius: 10px;
            overflow: hidden;
        }

        /* ── Contact Method Badge ── */
        .method-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .method-whatsapp {
            background-color: #dcfce7;
            color: #15803d;
        }

        .method-line {
            background-color: #d1fae5;
            color: #047857;
        }

        .method-phone {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        /* ── Email Link ── */
        .email-link {
            color: #0876dd;
            text-decoration: none;
            font-weight: 500;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        /* ── Message Box ── */
        .message-section {
            margin-top: 8px;
            margin-bottom: 24px;
        }

        .message-box {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-left: 4px solid #ffd200;
            border-radius: 0 10px 10px 0;
            padding: 20px 24px;
            font-size: 14px;
            color: #334155;
            line-height: 1.7;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* ── Attachment ── */
        .attachment-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #92400e;
        }

        .attachment-icon {
            font-size: 18px;
            line-height: 1;
        }

        /* ── Timestamp ── */
        .timestamp-row {
            text-align: center;
            padding: 16px 0 4px;
        }

        .timestamp {
            display: inline-block;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 20px;
        }

        /* ── Footer ── */
        .email-footer {
            background: #f8fafc;
            border-top: 1px solid #e8ecf1;
            padding: 24px 40px;
            text-align: center;
        }

        .footer-text {
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
            margin: 0;
        }

        .footer-brand {
            font-size: 13px;
            font-weight: 700;
            color: #043f73;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 8px;
        }

        /* ── Responsive ── */
        @media only screen and (max-width: 620px) {
            .email-wrapper {
                padding: 16px 12px !important;
            }

            .email-container {
                border-radius: 12px !important;
            }

            .email-header {
                padding: 32px 24px 28px !important;
            }

            .email-header h1 {
                font-size: 19px !important;
            }

            .email-body {
                padding: 28px 24px 20px !important;
            }

            .detail-grid td {
                padding: 10px 12px !important;
                font-size: 13px !important;
            }

            .detail-grid .label-cell {
                font-size: 12px !important;
            }

            .message-box {
                padding: 16px 18px !important;
                font-size: 13px !important;
            }

            .email-footer {
                padding: 20px 24px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <table class="email-container" role="presentation" cellpadding="0" cellspacing="0" width="600" align="center">
            <!-- Header -->
            <tr>
                <td class="email-header">
                    <h1>📬 Novo Contato Recebido</h1>
                    <p>Uma nova solicitação foi enviada pelo site</p>
                </td>
            </tr>

            <!-- Yellow Accent Bar -->
            <tr>
                <td>
                    <div class="header-accent"></div>
                </td>
            </tr>

            <!-- Body -->
            <tr>
                <td class="email-body">
                    <!-- Greeting -->
                    <p class="greeting">
                        Olá <strong>Equipe de Vendas</strong>,<br>
                        Um novo formulário de contato foi preenchido. Confira os detalhes abaixo:
                    </p>

                    <!-- Contact Details -->
                    <div class="detail-section">
                        <span class="section-label">Informações do Contato</span>
                        <div class="detail-card">
                            <table class="detail-grid" role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="label-cell">Método de Contato</td>
                                    <td class="value-cell">
                                        @php
                                            $methodClass = match($submission->contact_method) {
                                                'whatsapp' => 'method-whatsapp',
                                                'line' => 'method-line',
                                                default => 'method-phone',
                                            };
                                        @endphp
                                        <span class="method-badge {{ $methodClass }}">{{ strtoupper($submission->contact_method) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Assunto</td>
                                    <td class="value-cell">{{ $submission->subject }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">Nome</td>
                                    <td class="value-cell">{{ $submission->name }}</td>
                                </tr>
                                <tr>
                                    <td class="label-cell">E-mail</td>
                                    <td class="value-cell">
                                        <a href="mailto:{{ $submission->email }}" class="email-link">{{ $submission->email }}</a>
                                    </td>
                                </tr>
                                @if($submission->line_id)
                                <tr>
                                    <td class="label-cell">ID do LINE</td>
                                    <td class="value-cell">{{ $submission->line_id }}</td>
                                </tr>
                                @endif
                                @if($submission->phone)
                                <tr>
                                    <td class="label-cell">Telefone / WhatsApp</td>
                                    <td class="value-cell">{{ $submission->country_code }} {{ $submission->phone }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="label-cell">IP do Usuário</td>
                                    <td class="value-cell" style="color: #94a3b8; font-size: 13px;">{{ $submission->ip_address }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="message-section">
                        <span class="section-label">Mensagem</span>
                        <div class="message-box">{{ $submission->message }}</div>
                    </div>

                    <!-- Attachment -->
                    @if($submission->attachment_path)
                    <div class="attachment-bar">
                        <span class="attachment-icon">📎</span>
                        <span><strong>Anexo:</strong> {{ $submission->attachment_original_name }} — verifique os anexos deste e-mail.</span>
                    </div>
                    @endif

                    <!-- Timestamp -->
                    <div class="timestamp-row">
                        <span class="timestamp">📅 Recebido em {{ $submission->created_at->format('d/m/Y \à\s H:i') }}</span>
                    </div>
                </td>
            </tr>

            <!-- Footer -->
            <tr>
                <td class="email-footer">
                    <span class="footer-brand">Master Brindes</span>
                    <p class="footer-text">
                        Este e-mail foi gerado automaticamente pelo sistema do site.<br>
                        Por favor, não responda diretamente a esta mensagem.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
