@extends('layouts.app')

@section('title', __('messages.contact_complete.title'))

@section('css')
    <style>
        .complete-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 64px 16px 80px;
        }

        .complete-card {
            width: min(100%, 720px);
            background: #ffffff;
            border-radius: 12px;
            text-align: center;
            padding: 72px 48px 56px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .complete-card__icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 40px;
            border-radius: 50%;
            background: #ffd200;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .complete-card__icon i {
            font-size: 36px;
            color: #ffffff;
            line-height: 1;
        }

        .complete-card h1 {
            margin: 0 0 12px;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
            color: #111111;
        }

        .complete-card h1 span {
            color: #043f73;
        }

        .complete-card p {
            margin: 0 auto 36px;
            max-width: 440px;
            font-size: 15px;
            line-height: 1.6;
            color: #555555;
        }

        .complete-card__btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            min-width: 260px;
            height: 48px;
            padding: 0 32px;
            background: #ffd200;
            color: #000000;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            text-decoration: none;
            border-radius: 999px;
            letter-spacing: 0.4px;
            transition: transform 0.18s ease, filter 0.18s ease, box-shadow 0.18s ease;
        }

        .complete-card__btn:hover {
            filter: brightness(0.98);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
            color: #000000;
        }

        .complete-card__btn i {
            font-size: 18px;
            line-height: 1;
        }

        .complete-card__link {
            display: block;
            margin-top: 18px;
            font-size: 13px;
            color: #0876dd;
            text-decoration: underline;
        }

        .complete-card__link:hover {
            color: #043f73;
        }

        @media (max-width: 576px) {
            .complete-wrapper {
                padding: 40px 14px 60px;
            }

            .complete-card {
                padding: 52px 24px 40px;
            }

            .complete-card h1 {
                font-size: 22px;
            }

            .complete-card p {
                font-size: 14px;
            }

            .complete-card__btn {
                min-width: 220px;
                height: 44px;
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <section class="contact-hero" aria-labelledby="contact-complete-title">
        <div class="contact-hero__inner">
            <h1 id="contact-complete-title">{{ __('messages.contact_complete.hero_title') }}</h1>
            <p>{{ __('messages.contact_complete.hero_subtitle') }}</p>
        </div>
    </section>

    <section class="contact-page">
        <div class="contact-hex contact-hex--left" aria-hidden="true">
            <span class="contact-hex__cell contact-hex__cell--1"></span>
            <span class="contact-hex__cell contact-hex__cell--2"></span>
            <span class="contact-hex__cell contact-hex__cell--3"></span>
            <span class="contact-hex__cell contact-hex__cell--4"></span>
            <span class="contact-hex__cell contact-hex__cell--5"></span>
            <span class="contact-hex__cell contact-hex__cell--6"></span>
            <span class="contact-hex__cell contact-hex__cell--7"></span>
            <span class="contact-hex__cell contact-hex__cell--8"></span>
            <span class="contact-hex__cell contact-hex__cell--9"></span>
        </div>
        <div class="contact-hex contact-hex--right" aria-hidden="true">
            <span class="contact-hex__cell contact-hex__cell--1"></span>
            <span class="contact-hex__cell contact-hex__cell--2"></span>
            <span class="contact-hex__cell contact-hex__cell--3"></span>
            <span class="contact-hex__cell contact-hex__cell--4"></span>
            <span class="contact-hex__cell contact-hex__cell--5"></span>
            <span class="contact-hex__cell contact-hex__cell--6"></span>
            <span class="contact-hex__cell contact-hex__cell--7"></span>
            <span class="contact-hex__cell contact-hex__cell--8"></span>
            <span class="contact-hex__cell contact-hex__cell--9"></span>
        </div>

        <div class="complete-wrapper">
            <div class="complete-card">
                <div class="complete-card__icon" aria-hidden="true">
                    <i class="bi bi-check-lg"></i>
                </div>

                <h1>{{ __('messages.contact_complete.success_title') }}</h1>

                <p>
                    {{ __('messages.contact_complete.success_message') }}
                </p>

                <a href="{{ route('home') }}" class="complete-card__btn">
                    <span>{{ __('messages.contact_complete.continue_browsing') }}</span>
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>

                <a href="{{ route('home') }}" class="complete-card__link">
                    {{ __('messages.contact_complete.go_home') }}
                </a>
            </div>
        </div>
    </section>
@endsection
