@extends('layouts.app')

@section('title', 'Opções de Pagamento')
@section('css')
    <style>
        .payment-hero {
            background: #f5f7fb;
            padding: 42px 0;
        }

        .payment-hero-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .breadcrumb {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .payment-hero h1 {
            font-size: 64px;
            font-weight: 800;
            color: #000;
            margin: 0;
        }

        .hero-img {
            max-width: 210px;
            height: auto;
        }

        .payment-section {
            padding: 45px 0 60px;
            background: #fff;
        }

        .payment-block {
            margin-bottom: 55px;
        }

        .payment-block h2 {
            font-size: 25px;
            font-weight: 800;
            color: #000;
            padding-left: 12px;
            border-left: 4px solid #20c4c7;
            margin-bottom: 28px;
        }

        .paypal-content {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 60px;
            align-items: center;
        }

        .paypal-content h3 {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .paypal-content p {
            max-width: 520px;
            font-size: 14px;
            line-height: 1.7;
            color: #333;
        }

        .payment-list {
            list-style: none;
            padding: 0;
            margin-top: 18px;
        }

        .payment-list li {
            font-size: 14px;
            margin-bottom: 12px;
            color: #333;
        }

        .payment-list li::before {
            content: "✦";
            color: #20c4c7;
            margin-right: 10px;
        }

        .paypal-card {
            background: #f1f5fa;
            border-radius: 14px;
            padding: 35px;
            text-align: center;
        }

        .paypal-card img {
            max-width: 190px;
        }

        .bank-table-wrap {
            overflow-x: auto;
        }

        .bank-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .bank-table thead {
            background: #0f172a;
            color: #fff;
        }

        .bank-table th,
        .bank-table td {
            padding: 20px 34px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .bank-table th {
            font-weight: 800;
        }

        .bank-table td:first-child {
            font-weight: 700;
            color: #111827;
        }

        @media (max-width: 768px) {
            .payment-hero-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .payment-hero h1 {
                font-size: 32px;
            }

            .hero-img {
                max-width: 170px;
                align-self: center;
            }

            .paypal-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .paypal-card {
                max-width: 300px;
            }

            .bank-table th,
            .bank-table td {
                padding: 16px 18px;
                white-space: nowrap;
            }
        }
    </style>
@endsection
@section('content')

    <section class="payment-hero">
        <div class="container payment-hero-inner">
            <div>
                <div class="breadcrumb"><img src="{{ asset('assets/images/icon/ci_house-01.png') }}" alt=""> / Opções
                    de Pagamento</div>
                <h1>Opções de Pagamento</h1>
            </div>

            <img src="{{ asset('assets/images/payment/image-Photoroom (15) 1.png') }}" alt="Payment" class="hero-img">
        </div>
    </section>

    <section class="payment-section">
        <div class="container">

            <div class="payment-block">
                <h2>Pagamento via PayPal</h2>

                <div class="paypal-content">
                    <div>
                        <h3>Rápido, Global e Seguro</h3>
                        <p>
                            O PayPal permite que você pague sem compartilhar seus dados
                            financeiros diretamente com o site. É a forma mais rápida de compensação.
                        </p>

                        <ul class="payment-list">
                            <li>Compensação instantânea</li>
                            <li>Suporte a múltiplas moedas</li>
                            <li>Proteção ao Consumidor</li>
                        </ul>
                    </div>

                    <div class="paypal-card">
                        <img src="{{ asset('assets/images/payment/Group 1536.png') }}" alt="PayPal">
                    </div>
                </div>
            </div>

            <div class="payment-block">
                <h2>Transferência Bancária (JP banks)</h2>

                <div class="bank-table-wrap">
                    <table class="bank-table">
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Detalhes da Conta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Banco</td>
                                <td>Banco Yuzu (Yuzu Bank)</td>
                            </tr>
                            <tr>
                                <td>Agência (Branch)</td>
                                <td>001</td>
                            </tr>
                            <tr>
                                <td>Tipo de Conta</td>
                                <td>Ordinary (Futsu)</td>
                            </tr>
                            <tr>
                                <td>Número da Conta</td>
                                <td>1234567</td>
                            </tr>
                            <tr>
                                <td>Nome do Favorecido</td>
                                <td>XXKK TOYS LTD.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection
