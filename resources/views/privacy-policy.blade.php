@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('css')
    <style>
        .policy-page {
            background: #fff;
            padding: 42px 16px 60px;
        }

        .policy-container {
            max-width: 1060px;
            margin: 0 auto;
        }

        .policy-intro {
            /* max-width: 960px; */
            margin: 0 auto 28px;
            color: #111;
            font-size: 14px;
            line-height: 1.65;
        }

        .policy-intro p {
            margin: 0 0 18px;
        }

        .policy-divider {
            border: 0;
            border-top: 1px solid #e5e7eb;
            margin: 28px 0;
        }

        .policy-section {
            display: grid;
            grid-template-columns: 76px 1fr;
            gap: 26px;
            padding: 28px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .policy-icon-wrap {
            display: flex;
            justify-content: center;
        }

        .policy-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #eaf1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1c4a93;
        }

        .policy-icon svg {
            width: 36px;
            height: 36px;
            stroke-width: 1.8;
        }

        .policy-content h2 {
            margin: 0 0 10px;
            color: #17439a;
            font-size: 17px;
            font-weight: 700;
        }

        .policy-content p {
            margin: 0 0 14px;
            color: #111;
            font-size: 14px;
            line-height: 1.65;
        }

        .policy-subtitle {
            margin: 16px 0 10px;
            color: #17439a;
            font-size: 14px;
            font-weight: 700;
        }

        .security-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px 40px;
            margin-top: 10px;
        }

        .security-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #111;
            font-size: 13px;
            line-height: 1.45;
        }

        .security-check {
            width: 16px;
            height: 16px;
            min-width: 16px;
            border-radius: 50%;
            background: #1d5bd8;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            margin-top: 1px;
        }

        .policy-info-card {
            margin-left: 102px;
            margin-top: 28px;
            border: 1px solid #d7e3f8;
            background: #f8fbff;
            border-radius: 8px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            overflow: hidden;
        }

        .policy-info-item {
            display: grid;
            grid-template-columns: 42px 1fr;
            gap: 12px;
            padding: 20px 22px;
            border-right: 1px solid #d7e3f8;
            align-items: center;
        }

        .policy-info-item:last-child {
            border-right: 0;
        }

        .policy-info-icon {
            color: #17439a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .policy-info-icon svg {
            width: 34px;
            height: 34px;
            stroke-width: 1.8;
        }

        .policy-info-label {
            color: #17439a;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .policy-info-text {
            color: #111;
            font-size: 13px;
            line-height: 1.45;
        }

        @media (max-width: 768px) {
            .policy-page {
                padding: 28px 16px 44px;
            }

            .policy-section {
                grid-template-columns: 1fr;
                gap: 14px;
                padding: 24px 0;
            }

            .policy-icon-wrap {
                justify-content: flex-start;
            }

            .security-list {
                grid-template-columns: 1fr;
            }

            .policy-info-card {
                margin-left: 0;
                grid-template-columns: 1fr;
            }

            .policy-info-item {
                border-right: 0;
                border-bottom: 1px solid #d7e3f8;
            }

            .policy-info-item:last-child {
                border-bottom: 0;
            }
        }

        .policy-extra-section {
            max-width: 1060px;
            margin: 54px auto 0;
        }

        .policy-extra-block {
            margin-bottom: 58px;
        }

        .policy-extra-block h2 {
            margin: 0 0 18px;
            color: #111;
            font-size: 28px;
            font-weight: 600;
            line-height: 1.25;
        }

        .policy-extra-block p {
            margin: 0 0 24px;
            color: #111;
            font-size: 15px;
            line-height: 1.55;
        }

        .policy-accordion {
            margin-top: 38px;
        }

        .policy-accordion-item {
            border-bottom: 1px solid #e5e7eb;
        }

        .policy-accordion-btn {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 24px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            cursor: pointer;
            text-align: left;
            color: #003399;
            font-size: 18px;
            font-weight: 600;
            font-family: inherit;
        }

        .policy-accordion-icon {
            color: #111;
            font-size: 44px;
            font-weight: 300;
            line-height: 1;
            min-width: 32px;
            text-align: center;
        }


        .policy-accordion-content p {
            margin: 0 0 22px;
            font-size: 15px;
            line-height: 1.55;
        }

        .policy-accordion-content {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            padding: 0 40px;
            color: #111;
            transition:
                max-height 0.35s ease,
                opacity 0.25s ease,
                padding 0.35s ease;
        }

        .policy-accordion-content-inner {
            padding-bottom: 34px;
        }

        .policy-accordion-item.is-open .policy-accordion-content {
            max-height: 600px;
            opacity: 1;
            padding: 0 40px;
        }

        .policy-accordion-icon {
            color: #111;
            font-size: 44px;
            font-weight: 300;
            line-height: 1;
            min-width: 32px;
            text-align: center;
            transition: transform 0.25s ease;
        }

        .policy-accordion-item.is-open .policy-accordion-icon {
            transform: rotate(180deg);
        }

        @media (max-width: 768px) {
            .policy-accordion-content {
                padding: 0;
            }

            .policy-accordion-item.is-open .policy-accordion-content {
                padding: 0;
            }

            .policy-accordion-content-inner {
                padding-bottom: 28px;
            }
        }

        .policy-accordion-item.is-open .policy-accordion-icon {
            font-size: 40px;
        }

        @media (max-width: 768px) {
            .policy-extra-section {
                margin-top: 36px;
            }

            .policy-extra-block {
                margin-bottom: 42px;
            }

            .policy-extra-block h2 {
                font-size: 23px;
            }

            .policy-extra-block p {
                font-size: 14px;
            }

            .policy-accordion-btn {
                padding: 20px 0;
                font-size: 15px;
            }

            .policy-accordion-content {
                padding: 0 0 28px;
            }

            .policy-accordion-icon {
                font-size: 34px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <img src="{{ asset('assets/images/policy/Group 1475.png') }}" alt="" class="img-fluid w-100">
    </div>
    <section class="policy-page">

        <div class="container">

            <div class="policy-intro">
                <p>
                    Nós últimos anos, com o avanço da sociedade da informação, a preocupação social com a importância da
                    proteção de dados pessoais tem aumentado.
                    Consideramos que proteger os dados pessoais confiados por todos os clientes, incluindo empresas
                    relacionadas, é uma responsabilidade social da nossa empresa,
                    que atua no desenvolvimento de software e fornecimento de recursos humanos.
                </p>

                <p>
                    A empresa estabelece a seguinte Política de Proteção de Dados Pessoais, cria um sistema de proteção de
                    dados pessoais e promove a conscientização e o
                    comprometimento de todos os colaboradores quanto à importância da proteção de dados pessoais, declarando
                    assim o empenho na proteção das informações pessoais.
                </p>
            </div>

            <hr class="policy-divider">

            <div class="policy-section">
                <img src="{{ asset('assets/images/policy/Ellipse 803.png') }}" alt="" class="img-fluid">

                <div class="policy-content">
                    <h2>Artigo 1 – Coleta e Uso de Dados Pessoais</h2>
                    <p>
                        A empresa definirá claramente a finalidade de uso dos dados pessoais e os utilizará apenas dentro do
                        escopo dessa finalidade.
                        A finalidade de uso será registrada na lista de controle de dados pessoais, e cada responsável
                        departamental pela gestão de dados pessoais
                        implementará procedimentos de verificação para evitar o uso fora da finalidade estabelecida.
                    </p>
                    <p>
                        Além disso, a empresa organizará sistemas internos de gestão e adotará medidas de segurança para
                        impedir o uso dos dados pessoais além do escopo permitido.
                    </p>
                </div>
            </div>

            <div class="policy-section">
                <img src="{{ asset('assets/images/policy/Ellipse 804.png') }}" alt="" class="img-fluid">


                <div class="policy-content">
                    <h2>Artigo 2 – Gestão e Proteção de Dados Pessoais</h2>
                    <p>
                        A gestão dos dados pessoais será realizada de forma rigorosa. Exceto com o consentimento do cliente,
                        a empresa não divulgará nem fornecerá dados a terceiros.
                    </p>
                    <p>
                        Além disso, para prevenir vazamento, perda ou dano de dados pessoais, a empresa adotará medidas de
                        segurança apropriadas,
                        estabelecerá procedimentos preventivos e realizará ações corretivas imediatas em caso de incidentes.
                    </p>

                    <div class="policy-subtitle">Exemplos de medidas de segurança adotadas:</div>

                    <div class="security-list">
                        <div class="security-item">
                            <span class="security-check">✓</span>
                            <span>Restrição de acesso às informações pessoais</span>
                        </div>

                        <div class="security-item">
                            <span class="security-check">✓</span>
                            <span>Configuração de senhas e criptografia de dados pessoais</span>
                        </div>

                        <div class="security-item">
                            <span class="security-check">✓</span>
                            <span>Definição de permissões de acesso</span>
                        </div>

                        <div class="security-item">
                            <span class="security-check">✓</span>
                            <span>Restrição de gravação de dados em mídias externas</span>
                        </div>

                        <div class="security-item">
                            <span class="security-check">✓</span>
                            <span>Medidas contra acessos não autorizados a redes e dispositivos</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="policy-section">
                <img src="{{ asset('assets/images/policy/Ellipse 805.png') }}" alt="" class="img-fluid">


                <div class="policy-content">
                    <h2>Artigo 3 – Conformidade Legal</h2>
                    <p>
                        A empresa cumprirá as leis aplicáveis, diretrizes governamentais e demais normas relacionadas ao
                        tratamento de dados pessoais mantidos pela empresa.
                    </p>
                </div>
            </div>

            <div class="policy-section">
                <img src="{{ asset('assets/images/policy/Ellipse 806.png') }}" alt="" class="img-fluid">


                <div class="policy-content">
                    <h2>Artigo 4 – Atendimento a Consultas e Reclamações</h2>
                    <p>
                        A empresa estabelecerá sistemas e procedimentos adequados para receber e responder rapidamente a
                        consultas e reclamações relacionadas aos dados pessoais mantidos.
                    </p>
                </div>
            </div>

            <div class="policy-section">
                <img src="{{ asset('assets/images/policy/Ellipse 807.png') }}" alt="" class="img-fluid">


                <div class="policy-content">
                    <h2>Artigo 5 – Melhoria Contínua</h2>
                    <p>
                        A empresa realizará melhorias contínuas em seus sistemas e estruturas de gestão relacionados à
                        proteção de dados pessoais.
                    </p>
                </div>
            </div>

            <div class="policy-info-card">
                <div class="policy-info-item">
                    <img src="{{ asset('assets/images/policy/uil_schedule.png') }}" alt="" class="img-fluid">

                    <div>
                        <div class="policy-info-label">Data de estabelecimento:</div>
                        <div class="policy-info-text">01 de outubro de 2004</div>
                    </div>
                </div>

                <div class="policy-info-item">
                    <img src="{{ asset('assets/images/policy/fluent_building-24-regular.png') }}" alt=""
                        class="img-fluid">

                    <div>
                        <div class="policy-info-label">You and Earth Co., Ltd.</div>
                        <div class="policy-info-text">Diretor Representante: Masanori Kadota</div>
                    </div>
                </div>

                <div class="policy-info-item">
                    <img src="{{ asset('assets/images/policy/material-symbols_mail-outline-rounded.png') }}" alt=""
                        class="img-fluid">

                    <div>
                        <div class="policy-info-label">Contato para dúvidas e reclamações sobre dados pessoais</div>
                        <div class="policy-info-text">info@youandearth.com</div>
                    </div>
                </div>
            </div>
            <div class="policy-extra-block mt-4">
                <h2>Finalidade de Uso dos Dados Pessoais</h2>

                <p>
                    A finalidade de uso dos dados pessoais obtidos ou mantidos pela You and Earth Co., Ltd. é a seguinte:
                </p>

                <p>
                    <strong>1. Resposta a consultas dos clientes</strong><br>
                    Responder a consultas feitas pelos clientes via e-mail, correio, telefone e outros meios.
                </p>

                <p>
                    <strong>2. Outros usos</strong><br>
                    A empresa poderá utilizar dados pessoais para finalidades não especificadas acima em determinados
                    serviços.
                    Nesse caso, a finalidade será publicada no website do serviço correspondente.
                </p>
            </div>

            <div class="policy-extra-block">
                <h2>Procedimentos para Solicitação de Divulgação, Correção e Exclusão</h2>

                <p>
                    A empresa respeita os direitos individuais relativos aos dados pessoais mantidos e, mediante confirmação
                    da
                    identidade do solicitante, responderá dentro de um prazo razoável às solicitações de divulgação,
                    correção ou
                    exclusão de dados pessoais.
                    <br>
                    Entretanto, em relação a dados pessoais fornecidos por terceiros, a empresa não possui autoridade para
                    realizar
                    divulgações ou alterações.
                </p>

              <div class="policy-accordion">

    <div class="policy-accordion-item">
        <button type="button" class="policy-accordion-btn">
            <span>1. Destino das solicitações</span>
            <span class="policy-accordion-icon">+</span>
        </button>

        <div class="policy-accordion-content">
            <div class="policy-accordion-content-inner">
                <p>
                    As solicitações deverão ser enviadas por correio junto com os documentos necessários
                    utilizando métodos rastreáveis, como carta registrada.
                </p>

                <p>
                    Endereço:<br>
                    You and Earth Co., Ltd.<br>
                    〒135-0064<br>
                    TIME24 Building 5F Central<br>
                    2-4-32 Aomi, Koto-ku, Tokyo, Japão
                </p>

                <p>
                    Departamento responsável por consultas sobre dados pessoais.
                </p>
            </div>
        </div>
    </div>

    <div class="policy-accordion-item">
        <button type="button" class="policy-accordion-btn">
            <span>2. Documentos necessários</span>
            <span class="policy-accordion-icon">+</span>
        </button>

        <div class="policy-accordion-content">
            <div class="policy-accordion-content-inner">
                <p>
                    Para confirmar a identidade do solicitante, poderá ser necessário apresentar cópia de documento
                    oficial, como passaporte, carteira de identidade ou outro documento equivalente.
                </p>
            </div>
        </div>
    </div>

    <div class="policy-accordion-item">
        <button type="button" class="policy-accordion-btn">
            <span>3. Documentos para confirmação de identidade</span>
            <span class="policy-accordion-icon">+</span>
        </button>

        <div class="policy-accordion-content">
            <div class="policy-accordion-content-inner">
                <p>
                    Quando a solicitação for realizada por representante, será necessário apresentar documento
                    que comprove a autorização de representação, além do documento de identidade do representante.
                </p>
            </div>
        </div>
    </div>

    <div class="policy-accordion-item">
        <button type="button" class="policy-accordion-btn">
            <span>4. Taxa para solicitação de divulgação e notificação de finalidade de uso</span>
            <span class="policy-accordion-icon">+</span>
        </button>

        <div class="policy-accordion-content">
            <div class="policy-accordion-content-inner">
                <p>
                    Poderá ser cobrada uma taxa administrativa para solicitações de divulgação ou notificação de
                    finalidade de uso, conforme o procedimento estabelecido pela empresa.
                </p>
            </div>
        </div>
    </div>

    <div class="policy-accordion-item">
        <button type="button" class="policy-accordion-btn">
            <span>5. Forma de resposta</span>
            <span class="policy-accordion-icon">+</span>
        </button>

        <div class="policy-accordion-content">
            <div class="policy-accordion-content-inner">
                <p>
                    A resposta será enviada ao endereço informado pelo solicitante, por correio ou outro meio
                    adequado, após a confirmação da identidade e análise da solicitação.
                </p>
            </div>
        </div>
    </div>

</div>

            </div>

    </section>


@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionButtons = document.querySelectorAll('.policy-accordion-btn');

            accordionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const item = this.closest('.policy-accordion-item');
                    const content = item.querySelector('.policy-accordion-content');
                    const inner = item.querySelector('.policy-accordion-content-inner');
                    const icon = this.querySelector('.policy-accordion-icon');

                    if (!item || !content || !inner || !icon) {
                        return;
                    }

                    const isOpen = item.classList.contains('is-open');

                    if (isOpen) {
                        content.style.maxHeight = content.scrollHeight + 'px';

                        requestAnimationFrame(function() {
                            item.classList.remove('is-open');
                            content.style.maxHeight = '0px';
                            icon.textContent = '+';
                        });
                    } else {
                        item.classList.add('is-open');
                        content.style.maxHeight = inner.scrollHeight + 'px';
                        icon.textContent = '−';
                    }
                });
            });
        });
    </script>
@endsection
