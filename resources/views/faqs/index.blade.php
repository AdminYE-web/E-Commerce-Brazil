@extends('layouts.app')

@section('title', 'FAQs')

@section('css')
    <style>
        .faq-hero {
            background: #fff;
            padding: 56px 16px 34px;
        }

        .faq-hero-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 32px;
            align-items: center;
        }

        .faq-breadcrumb {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #17439a;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .faq-breadcrumb a {
            color: #17439a;
            text-decoration: none;
        }

        .faq-hero-title {
            margin: 0;
            color: #000;
            font-size: 52px;
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .faq-hero-title span {
            display: inline-block;
            padding-left: 22px;
            margin-left: 18px;
            border-left: 3px solid #111;
        }

        .faq-hero-img {
            text-align: right;
        }

        .faq-hero-img img {
            max-width: 240px;
            width: 100%;
            height: auto;
        }

        .faq-divider {
            height: 24px;
            background: #24475f;
        }

        .faq-main {
            background: #edf8f6;
            padding: 44px 16px 70px;
            min-height: 520px;
        }

        .faq-container {
            max-width: 990px;
            margin: 0 auto;
        }

        .faq-section-title {
            margin: 0 0 26px;
            color: #000;
            font-size: 18px;
            font-weight: 900;
        }

        .faq-list {
            border-top: 0;
        }

        .faq-item {
            border-bottom: 1px solid #cbd8d6;
        }

        .faq-question-btn {
            width: 100%;
            border: 0;
            background: transparent;
            padding: 18px 10px 18px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            text-align: left;
            cursor: pointer;
            color: #000;
        }

        .faq-question-text {
            font-size: 16px;
            line-height: 1.45;
            font-weight: 900;
        }

        .faq-question-icon {
            width: 24px;
            flex: 0 0 24px;
            text-align: center;
            color: #111;
            font-size: 16px;
            transition: transform .25s ease;
        }

        .faq-item.is-open .faq-question-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height .28s ease;
        }

        .faq-answer-inner {
            padding: 0 56px 18px 22px;
            color: #111;
            font-size: 15px;
            line-height: 1.55;
            white-space: pre-line;
        }

        .faq-pagination {
            margin-top: 26px;
            display: flex;
            justify-content: center;
        }

        .faq-empty {
            padding: 32px;
            border-radius: 12px;
            background: #fff;
            color: #777;
            text-align: center;
        }

        /* Laravel pagination ให้ดูใกล้รูป */
        .faq-pagination nav {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .faq-pagination .pagination {
            display: flex;
            align-items: center;
            gap: 12px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .faq-pagination .page-link {
            border: 0;
            background: transparent;
            color: #111;
            font-size: 14px;
            text-decoration: none;
            padding: 4px 7px;
            border-radius: 999px;
        }

        .faq-pagination .page-item.active .page-link {
            background: #3b7b70;
            color: #fff;
            min-width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .faq-pagination .page-item.disabled .page-link {
            opacity: .45;
        }

        @media (max-width: 768px) {
            .faq-hero {
                padding: 36px 16px 26px;
            }

            .faq-hero-inner {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .faq-hero-title {
                font-size: 34px;
            }

            .faq-hero-title span {
                display: block;
                margin-left: 0;
                margin-top: 8px;
                padding-left: 0;
                border-left: 0;
            }

            .faq-hero-img {
                text-align: center;
            }

            .faq-hero-img img {
                max-width: 190px;
            }

            .faq-main {
                padding: 34px 16px 56px;
            }

            .faq-answer-inner {
                padding-right: 20px;
            }
        }

        .faq-pagination-custom {
            margin-top: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }

        .faq-page-number,
        .faq-page-arrow,
        .faq-page-dots {
            min-width: 22px;
            height: 22px;
            color: #111;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .faq-page-number {
            border-radius: 999px;
            padding: 0 6px;
        }

        .faq-page-number.is-active {
            background: #3b7b70;
            color: #fff;
            font-weight: 800;
        }

        .faq-page-arrow {
            font-size: 20px;
            line-height: 1;
        }

        .faq-page-arrow:hover,
        .faq-page-number:hover {
            color: #3b7b70;
        }

        .faq-page-arrow.is-disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        .faq-page-dots {
            color: #111;
        }

        .faq-contact {
            border: 1px solid;
            color: white;
            background: #163C76;
            padding: 9px;
            border-radius: 10px;
            text-decoration: none;
        }

        .faq-contact:hover {
            color: white;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')

    <section class="faq-hero">
        <div class="faq-hero-inner">
            <div>
                <div class="faq-breadcrumb">
                    <a href="{{ route('home') }}">⌂</a>
                    <span>/ FAQS</span>
                </div>

                <h1 class="faq-hero-title">
                    FAQS <span>Perguntas Frequentes</span>
                </h1>
            </div>

            <div class="faq-hero-img">
                <img src="{{ asset('assets/images/faq/faq-hero.png') }}" alt="FAQs">
            </div>
        </div>
    </section>

    <div class="faq-divider"></div>

    <section class="faq-main">
        <div class="faq-container">
            <h2 class="faq-section-title">
                Perguntas Frequentes
            </h2>

            @if ($faqs->count())
                <div class="faq-list">
                    @foreach ($faqs as $faq)
                        <div class="faq-item {{ $loop->first ? 'is-open' : '' }}">
                            <button type="button" class="faq-question-btn">
                                <span class="faq-question-text">
                                    Q{{ $faqs->firstItem() + $loop->index }} : {{ $faq->question }}
                                </span>

                                <span class="faq-question-icon">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </button>

                            <div class="faq-answer" style="{{ $loop->first ? 'max-height: 500px;' : '' }}">
                                <div class="faq-answer-inner">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($faqs->hasPages())
                    <div class="faq-pagination-custom">

                        {{-- Previous --}}
                        @if ($faqs->onFirstPage())
                            <span class="faq-page-arrow is-disabled">←</span>
                        @else
                            <a href="{{ $faqs->previousPageUrl() }}" class="faq-page-arrow">←</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($faqs->getUrlRange(1, $faqs->lastPage()) as $page => $url)
                            @if ($page === 1 || $page === $faqs->lastPage() || abs($page - $faqs->currentPage()) <= 1)
                                @if ($page === $faqs->currentPage())
                                    <span class="faq-page-number is-active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="faq-page-number">{{ $page }}</a>
                                @endif
                            @elseif (
                                ($page === 2 && $faqs->currentPage() > 4) ||
                                    ($page === $faqs->lastPage() - 1 && $faqs->currentPage() < $faqs->lastPage() - 3))
                                <span class="faq-page-dots">...</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($faqs->hasMorePages())
                            <a href="{{ $faqs->nextPageUrl() }}" class="faq-page-arrow">→</a>
                        @else
                            <span class="faq-page-arrow is-disabled">→</span>
                        @endif

                    </div>
                @endif
            @else
                <div class="faq-empty">
                    No FAQs found.
                </div>
            @endif
        </div>
        <div class="text-center mt-4">
            <a class="faq-contact" href="{{ route('contact') }}">Não encontrou a resposta? Entre em contato e nós
                ajudaremos.</a>
        </div>
    </section>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.faq-question-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const item = this.closest('.faq-item');
                    const answer = item.querySelector('.faq-answer');
                    const isOpen = item.classList.contains('is-open');

                    document.querySelectorAll('.faq-item').forEach(function(otherItem) {
                        otherItem.classList.remove('is-open');

                        const otherAnswer = otherItem.querySelector('.faq-answer');
                        if (otherAnswer) {
                            otherAnswer.style.maxHeight = null;
                        }
                    });

                    if (!isOpen) {
                        item.classList.add('is-open');
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    }
                });
            });
        });
    </script>
@endsection
