<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Novo Contato Recebido</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #111111;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #043f73;
            color: #ffffff;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
            margin-top: 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table th, .details-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eeeeee;
            text-align: left;
            font-size: 15px;
        }
        .details-table th {
            color: #111111;
            width: 35%;
            font-weight: 600;
            background-color: #f9fbfd;
        }
        .details-table td {
            color: #555555;
        }
        .message-box {
            background-color: #f9fbfd;
            border-left: 4px solid #ffd200;
            padding: 15px 20px;
            margin-top: 20px;
            font-size: 15px;
            color: #333333;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f4f7f6;
            padding: 20px 40px;
            text-align: center;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #eeeeee;
        }
        .badge {
            display: inline-block;
            background-color: #e6f0fa;
            color: #043f73;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Novo Contato Recebido</h1>
        </div>
        <div class="content">
            <p>Olá Equipe de Vendas,</p>
            <p>Um novo formulário de contato foi enviado através do site. Abaixo estão os detalhes:</p>

            <table class="details-table">
                <tr>
                    <th>Método de Contato</th>
                    <td><span class="badge">{{ strtoupper($submission->contact_method) }}</span></td>
                </tr>
                <tr>
                    <th>Assunto</th>
                    <td>{{ $submission->subject }}</td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td>{{ $submission->name }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td><a href="mailto:{{ $submission->email }}" style="color: #0876dd; text-decoration: none;">{{ $submission->email }}</a></td>
                </tr>
                @if($submission->line_id)
                <tr>
                    <th>ID do LINE</th>
                    <td>{{ $submission->line_id }}</td>
                </tr>
                @endif
                @if($submission->phone)
                <tr>
                    <th>Telefone / WhatsApp</th>
                    <td>{{ $submission->country_code }} {{ $submission->phone }}</td>
                </tr>
                @endif
                <tr>
                    <th>IP do Usuário</th>
                    <td>{{ $submission->ip_address }}</td>
                </tr>
            </table>

            <h3 style="margin-top: 30px; margin-bottom: 10px; color: #111111; font-size: 16px;">Mensagem:</h3>
            <div class="message-box">{{ $submission->message }}</div>

            @if($submission->attachment_path)
            <p style="margin-top: 20px; font-size: 14px;">
                <strong>Anexo:</strong> Um arquivo foi anexado a esta mensagem ({{ $submission->attachment_original_name }}). Verifique os anexos deste e-mail.
            </p>
            @endif
        </div>
        <div class="footer">
            Este e-mail foi gerado automaticamente pelo sistema do site.
        </div>
    </div>
</body>
</html>
