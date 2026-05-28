@extends('layouts.app')


@section('title', 'Cancelamento / Alteração')

@section('css')
<style>
    .cancel-page {
        font-family: "Inter", sans-serif;
        color: #111;
        background: #fff;
    }

    .cancel-container {
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Header */
    .cancel-hero {
        background: #f6f7f9;
        padding: 44px 0 48px;
    }

    .cancel-hero-inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #56709b;
        margin-bottom: 10px;
    }

    .breadcrumb-custom a {
        color: #305c9b;
        text-decoration: none;
    }

    .cancel-hero h1 {
        font-size: clamp(34px, 5vw, 54px);
        font-weight: 800;
        letter-spacing: -1px;
        margin: 0 0 14px;
    }

    .cancel-hero p {
        color: #999;
        font-size: 13px;
        margin: 0;
    }

    .hero-img img {
        max-width: 180px;
        display: block;
    }

    /* Tabs */
    .cancel-tabs {
        display: flex;
        justify-content: center;
        gap: 48px;
        margin: 52px 0 42px;
    }

    .tab-btn {
        background: transparent;
        border: 0;
        padding: 0 0 8px;
        font-size: 16px;
        font-weight: 600;
        color: #999;
        cursor: pointer;
        position: relative;
    }

    .tab-btn.active {
        color: #111;
    }

    .tab-btn.active::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #111;
    }

    /* Content */
    .tab-content {
        display: none;
        max-width: 960px;
        margin: 0 auto 60px;
    }

    .tab-content.active {
        display: block;
    }

    .tab-content h2 {
        text-align: center;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 48px;
    }

    .intro {
        font-size: 16px;
        line-height: 1.45;
        margin-bottom: 22px;
    }

    .policy-card {
        background: #f7f7f7;
        padding: 18px 20px;
        margin-bottom: 20px;
    }

    .policy-card h3 {
        font-size: 16px;
        margin: 0 0 12px;
        font-weight: 700;
    }

    .policy-card small {
        display: block;
        color: #9a9a9a;
        font-size: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eeeeee;
        margin-bottom: 14px;
    }

    .policy-card p {
        font-size: 13px;
        line-height: 1.45;
        color: #8a8a8a;
        margin: 0;
    }

    .policy-card .danger-text {
        color: #c40000;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .cancel-hero {
            padding: 34px 0;
        }

        .cancel-hero-inner {
            align-items: flex-start;
        }

        .hero-img img {
            max-width: 110px;
        }

        .cancel-tabs {
            gap: 24px;
            overflow-x: auto;
            justify-content: flex-start;
            margin: 36px 0 34px;
            padding-bottom: 4px;
        }

        .tab-btn {
            white-space: nowrap;
            font-size: 14px;
        }

        .tab-content h2 {
            margin-bottom: 32px;
        }

        .intro {
            font-size: 14px;
        }
    }

    .return-section {
        margin-top: 54px;
    }

    .return-section h2 {
        text-align: center;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 28px;
    }

    .return-intro-box {
        background: #f7f7f7;
        padding: 18px 20px;
        margin-bottom: 24px;
    }

    .return-intro-box h3 {
        font-size: 13px;
        font-weight: 600;
        margin: 0 0 14px;
    }

    .return-intro-box p {
        font-size: 12px;
        line-height: 1.6;
        color: #8a8a8a;
        margin: 0;
    }

    .case-title {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        margin: 22px 0 12px;
    }

    .case-title span {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        flex: 0 0 auto;
    }

    .case-title-green {
        color: #168b31;
    }

    .case-title-green span {
        background: #28a745;
    }

    .case-title-red {
        color: #d10000;
    }

    .case-title-red span {
        background: #d10000;
    }

    .case-table {
        border: 1px solid #e6e6e6;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 26px;
    }

    .case-row {
        display: grid;
        grid-template-columns: 36% 64%;
    }

    .case-row>div {
        padding: 18px 22px;
        font-size: 12px;
        line-height: 1.55;
        border-right: 1px solid #e6e6e6;
        border-bottom: 1px solid #e6e6e6;
    }

    .case-row>div:last-child {
        border-right: 0;
    }

    .case-row:last-child>div {
        border-bottom: 0;
    }

    .case-head>div {
        background: #dedede;
        font-weight: 700;
        color: #111;
    }

    @media (max-width: 768px) {
        .case-row {
            grid-template-columns: 1fr;
        }

        .case-row>div {
            border-right: 0;
        }

        .case-head {
            display: none;
        }

        .case-row>div:first-child {
            background: #f2f2f2;
            font-weight: 600;
        }

        .return-section h2 {
            font-size: 13px;
            line-height: 1.4;
        }
    }
</style>
@endsection

@section('content')

<section class="cancel-page">

    {{-- Header --}}
    <div class="cancel-hero">
        <div class="container cancel-container">
            <div class="cancel-hero-inner">

                <div>
                    <div class="breadcrumb-custom">
                        <span>⌂</span>
                        <a href="#">Cancelamento</a>
                        <span>/</span>
                        <a href="#">Alteração</a>
                    </div>

                    <h1>Cancelamento / Alteração</h1>
                    <p>Última atualização: May 2026</p>
                </div>

                <div class="hero-img">
                    <img src="{{ asset('assets/images/icon/Group 1559.png') }}" alt="Cancelamento">
                </div>

            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="container cancel-container">

        {{-- Tabs --}}
        <div class="cancel-tabs">
            <button class="tab-btn active" data-tab="brindes">
                Brindes Personalizados
            </button>

            <button class="tab-btn" data-tab="cordao">
                Cordão Personalizado
            </button>
        </div>

        {{-- Tab Content: Brindes --}}
        <div class="tab-content active" id="brindes">

            <h2>POLÍTICA DE CANCELAMENTO</h2>

            <p class="intro">
                Como nossos produtos são itens personalizados (feitos sob encomenda),
                nossa política de cancelamento e reembolso é baseada no progresso do trabalho
                (Progress-based), conforme detalhado abaixo:
            </p>

            <div class="policy-card">
                <h3>Etapa A: Após a confirmação do pedido</h3>
                <small>Pagamento concluído e número do pedido gerado</small>
                <p>
                    O reembolso será realizado na conta bancária indicada, mediante a dedução
                    de taxas administrativas incluindo os custos de vetorização/reprodução do design,
                    caso o serviço já tenha sido executado. Lembramos que as tarifas de transferência
                    bancária para envio do reembolso são de responsabilidade do cliente.
                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa B: Antes da produção em massa</h3>
                <small>Pagamento confirmado, mas a produção em massa ainda não foi iniciada.</small>
                <p>
                    O reembolso do valor será efetuado após a dedução dos seguintes custos
                    conforme contratados em seu pedido: taxa de envio de amostra física,
                    taxa de vetorização/reprodução do design e taxa de impressão no verso.
                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa C: Após a produção em massa</h3>
                <small>Produção em massa iniciada</small>
                <p class="danger-text">
                    ✕ Lamentamos profundamente, mas não é possível realizar o cancelamento ou reembolso
                    sob nenhuma circunstância, incluindo atrasos na entrega devido a prazos de eventos.
                </p>
            </div>

        </div>

        {{-- Tab Content: Cordão --}}
        <div class="tab-content" id="cordao">

            <h2>POLÍTICA DE CANCELAMENTO</h2>



            <div class="policy-card">
                <h3>Etapa A: Após a confirmação do pedido</h3>
                <small>Pagamento concluído e número do pedido gerado</small>
                <p>
                    Será deduzida uma taxa fixa de processamento de dados de 2.200 JPY antes do reembolso. O cliente é responsável pelas taxas de transferência bancária.
                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa B: Antes da produção em massa</h3>
                <small>Pagamento confirmado, mas a produção em massa ainda não foi iniciada.</small>
                <p>
                    Serão aplicadas taxas fixas de cancelamento com base no tipo de cordão selecionado: <br>
                    ① Cordão Premium : 16.500 JPY + 4.400 JPY por cor de impressão.

                    ② Cordão Standard : 14.300 JPY + 4.400 JPY por cor de impressão. <br>

                    ③ Cordão Full Color : 16.500 JPY (Impressão em um ou ambos os lados). <br>

                    ④ Cordão de Couro Sintético : 20.900 JPY + 4.400 JPY por cor de impressão. <br>

                    ⑤ Pulseira de Silicone/PVC : 16.500 JPY + 4.400 JPY por cor de impressão. <br>

                    ⑥ Cordão Redondo (Corda) : 20.900 JPY + 4.400 JPY por cor de impressão. <br>

                    ⑦ Porta-Crachá Personalizado : 20.900 JPY + 4.400 JPY por cor de impressão. <br>

                    ⑧ Porta-Cartões : 27.500 JPY + 4.400 JPY por cor de impressão
                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa C: Após a produção em massa</h3>
                <small>Produção em massa iniciada</small>
                <p class="danger-text">
                    ❌ Lamentamos profundamente, mas não é possível realizar o cancelamento ou reembolso sob nenhuma circunstância (incluindo atrasos na entrega devido a prazos de eventos).
                </p>
            </div>

            <h2>POLÍTICA DE ALTERAÇÃO DE PEDIDOS</h2>



            <div class="policy-card">
                <h3>Etapa A: Após a confirmação do pedido</h3>
                <small>Pagamento concluído e número do pedido gerado</small>
                <p>
                    Você pode solicitar alterações em seu pedido.Entre em contato com o nosso representante de vendas para informar as modificações desejadas. É possível alterar o pedido quantas vezes for necessário; no entanto, a cada alteração, os dados do design deverão passar por uma nova verificação na fábrica, o que poderá atrasar o início da produção. As alterações em si não possuem custos adicionais. Contudo, caso seja necessária uma nova revisão do layout (draft), será cobrada uma taxa de verificação conforme a tabela estabelecida.
                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa B: Antes da produção em massa</h3>
                <small>Pagamento confirmado, mas a produção em massa ainda não foi iniciada.</small>
                <p>
                    ① Alteração no conteúdo da impressão dos Cordões Hot Strap Premium : <br>
                    4.400 ienes × número de cores impressas (imposto incluído). <br>
                    Caso haja alteração no logotipo de resina do fecho ou do clipe: 9.900 ienes (o valor é o mesmo, seja alterando um deles ou ambos). <br><br>

                    ② Alteração no conteúdo da impressão dos Cordões Standard Polyester e Standard Nylon : <br>
                    4.400 ienes × número de cores impressas (imposto incluído). <br>
                    Caso haja alteração na cor do tingimento especial: 7.700 ienes (imposto incluído). <br><br>

                    ③ Alteração para impressão colorida (Full Color) : <br>
                    Independentemente da quantidade de cores na impressão full color, a alteração do pedido poderá ser feita pelo valor fixo de 11.000 ienes (imposto incluído). <br><br>
                    O tempo e os custos necessários para as alterações variam de acordo com as modificações solicitadas. Por exemplo, se você alterar o logotipo impresso no cordão, será necessário criar um novo molde, o que estenderá o prazo de produção em cerca de uma semana. Além disso, se você solicitou uma cor personalizada e os cordões já tiverem sido tingidos na cor especificada, todos os cordões planejados para a produção em massa também serão afetados, resultando em um custo de alteração mais elevado. O tempo e os custos exatos para cada modificação serão calculados caso a caso, e você será notificado detalhadamente.


                </p>
            </div>

            <div class="policy-card">
                <h3>Etapa C: Após a produção em massa</h3>
                <small>Produção em massa iniciada</small>
                <p class="danger-text">
                    ❌ Lamentamos profundamente, mas não podemos aceitar qualquer tipo de alteração em seu pedido após o início da produção em massa.Por favor, esteja ciente de que, mesmo se você decidir que não deseja mais os produtos já fabricados, não será possível realizar o reembolso do valor pago.
                </p>
            </div>
            {{-- Devoluções e Trocas - Cordão --}}
            <section class="return-section">

                <h2>DEVOLUÇÕES E TROCAS (REPRODUÇÃO) DE PRODUTOS ENCOMENDADOS</h2>

                <div class="return-intro-box">
                    <h3>Este documento explica a política de devolução de produtos após a entrega.</h3>
                    <p>
                        Os produtos de Cordão Personalizado são, em princípio, todos originais e baseados
                        nas especificações fornecidas pelo cliente. Portanto, independentemente do motivo,
                        não podemos aceitar devoluções após o início da produção em massa, incluindo após
                        a entrega do produto. Após a entrega, responderemos com devoluções e trocas
                        (reprodução) dependendo da situação. Seguem alguns exemplos de casos em que
                        devoluções e trocas (reprodução) são possíveis. Em princípio, devoluções e trocas
                        só são possíveis se reconhecermos que existe um defeito no produto que fabricamos.
                        Não podemos aceitar solicitações de devolução ou troca de produtos por conveniência
                        do cliente.
                    </p>
                </div>

                <div class="case-title case-title-green">
                    <span></span>
                    CASOS EM QUE A DEVOLUÇÃO OU TROCA (REPRODUÇÃO) É POSSÍVEL
                </div>

                <div class="case-table">
                    <div class="case-row case-head">
                        <div>Exemplo de Caso</div>
                        <div>Nossa Solução</div>
                    </div>

                    <div class="case-row">
                        <div>
                            O produto entregue está claramente diferente do que foi pedido.
                            (Ex: Você pediu cordões na cor vermelha, mas recebeu na cor azul).
                        </div>
                        <div>
                            Enviaremos o produto correto o mais rápido possível. Todos os custos envolvidos
                            na troca, tais como custos de fabricação, frete, etc., serão arcados integralmente
                            por nossa empresa. Por favor, note que a reprodução dos novos produtos exigirá
                            um determinado número de dias.
                        </div>
                    </div>

                    <div class="case-row">
                        <div>
                            Foram encontrados produtos defeituosos misturados no lote entregue.
                        </div>
                        <div>
                            Após nos notificar sobre o defeito, poderemos solicitar o envio dos produtos
                            defeituosos de volta para nossa empresa. Os custos de envio do retorno serão
                            arcados por nós. Assim que o defeito for confirmado, fabricaremos os produtos
                            corretos rapidamente. A reprodução dos itens exigirá determinado número de dias.
                        </div>
                    </div>
                </div>

                <div class="case-title case-title-red">
                    <span></span>
                    CASOS EM QUE A DEVOLUÇÃO OU TROCA (REPRODUÇÃO) NÃO É POSSÍVEL
                </div>

                <div class="case-table">
                    <div class="case-row case-head">
                        <div>Exemplo de Caso</div>
                        <div>Nossa Solução</div>
                    </div>

                    <div class="case-row">
                        <div>
                            Eu pedi os cordões, mas eles ficaram mais longos do que eu imaginava,
                            então gostaria de alterá-los para um comprimento menor. Se isso não for possível,
                            quero devolver ou trocar.
                        </div>
                        <div>
                            O comprimento do cordão finalizado é baseado no desenho técnico de aprovação
                            enviado antes da produção. Devoluções não serão aceitas se o comprimento real
                            do produto diferir da especificação no desenho técnico. Não aceitamos devolução
                            ou troca por preferências pessoais do cliente, incluindo casos em que haja uma
                            margem de erro aceitável no comprimento do cordão. Consulte os Termos de Isenção
                            de Responsabilidade para mais detalhes.
                        </div>
                    </div>

                    <div class="case-row">
                        <div>
                            Eu pedi os cordões para usar em um evento. No entanto, o evento foi cancelado
                            após a entrega, por isso não preciso mais deles e gostaria de devolvê-los.
                            Quero o reembolso do valor da produção, mesmo que seja parcial.
                        </div>
                        <div>
                            Lamentamos profundamente, mas após o início da produção em massa e após a entrega,
                            não podemos atender a nenhuma solicitação de reembolso, exceto nos casos em que
                            haja um defeito de fabricação de nossa responsabilidade. Agradecemos a sua compreensão.
                        </div>
                    </div>
                </div>

            </section>


        </div>

    </div>

</section>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const target = this.dataset.tab;

                buttons.forEach(btn => btn.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(target).classList.add('active');
            });
        });
    });
</script>
@endsection