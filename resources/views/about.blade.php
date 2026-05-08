@extends('layouts.app')

@section('title', __('about.page_title'))

@php
    $teamImages = ['team-02.webp', 'team-01.webp', 'team-03.webp'];
    $whyIcons = ['bi-box-seam', 'bi-truck', 'bi-building', 'bi-patch-check'];
@endphp

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/about.css') }}?v={{ date('is') }}">
@endsection

@section('content')
    <div class="about-page">
        <section class="about-hero" aria-labelledby="about-title">
            <div class="about-hero__ghost" aria-hidden="true">{{ __('about.hero.background_text') }}</div>
            <div class="about-hero__content">
                <h1 id="about-title">{{ __('about.hero.title') }}</h1>
                <p>{{ __('about.hero.subtitle') }}</p>
            </div>
        </section>

        <section class="about-ceo" aria-labelledby="ceo-title">
            <div class="about-container about-ceo__grid">
                <div class="about-ceo__copy">
                    <h2 id="ceo-title" class="about-section-title">{{ __('about.ceo.title') }}</h2>

                    @foreach (__('about.ceo.message') as $block)
                        @if ($block['type'] === 'heading')
                            <p class="about-ceo__lead">{{ $block['text'] }}</p>
                        @elseif ($block['type'] === 'list')
                            <ul class="about-ceo__list">
                                @foreach ($block['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $block['text'] }}</p>
                        @endif
                    @endforeach

                    <div class="about-ceo__signature">
                        <strong>{{ __('about.ceo.name') }}</strong>
                        <span>{{ __('about.ceo.position') }}</span>
                    </div>
                </div>

                <div class="about-ceo__image">
                    <img src="{{ asset('assets/images/about/ceo.webp') }}" alt="{{ __('about.ceo.image_alt') }}">
                </div>
            </div>
        </section>

        <section class="about-team" aria-labelledby="team-title">
            <div class="about-team__heading">
                <h2 id="team-title">{{ __('about.team.title') }}</h2>
                <p>{{ __('about.team.subtitle') }}</p>
                {{-- <div class="about-team__controls" aria-label="{{ __('about.team.carousel_label') }}">
                    <button type="button" class="about-team__arrow" data-team-prev aria-label="{{ __('about.team.previous') }}">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="about-team__arrow" data-team-next aria-label="{{ __('about.team.next') }}">
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </button>
                </div> --}}
            </div>

            <div class="about-team__rail" data-team-rail tabindex="0" aria-label="{{ __('about.team.carousel_label') }}">
                <div class="about-team__track">
                    @foreach (__('about.team.members') as $member)
                        <article class="about-team-card {{ ! empty($member['peek']) ? 'about-team-card--peek' : '' }}">
                            <div class="about-team-card__image">
                                <img src="{{ asset('assets/images/about/' . ($teamImages[$loop->index] ?? $teamImages[0])) }}" alt="{{ $member['name'] }}">
                            </div>
                            <div class="about-team-card__body">
                                <h3>{{ $member['name'] }}</h3>
                                <p>{{ $member['position'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-history" aria-labelledby="history-title">
            <div class="about-container">
                <h2 id="history-title" class="about-section-title">{{ __('about.history.title') }}</h2>

                <div class="about-timeline">
                    @foreach (__('about.history.items') as $item)
                        <article class="about-timeline__item">
                            <span class="about-timeline__dot" aria-hidden="true"></span>
                            <time class="about-timeline__year">{{ $item['year'] }}</time>
                            <div class="about-timeline__card">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['description'] }}</p>
                            </div>
                        </article>
                    @endforeach

                    @foreach (__('about.history.extra_items') as $item)
                        <article class="about-timeline__item" data-history-extra hidden>
                            <span class="about-timeline__dot" aria-hidden="true"></span>
                            <time class="about-timeline__year">{{ $item['year'] }}</time>
                            <div class="about-timeline__card">
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['description'] }}</p>
                            </div>
                        </article>
                    @endforeach

                    <button type="button" class="about-timeline__more" data-history-more data-show-more="{{ __('about.history.show_more') }}" data-show-less="{{ __('about.history.show_less') }}" aria-expanded="false">{{ __('about.history.show_more') }}</button>
                </div>
            </div>
        </section>

        <section class="about-why" aria-labelledby="why-title">
            <div class="about-container">
                <h2 id="why-title">{{ __('about.why_choose_us.title') }}</h2>
                <div class="about-why__grid">
                    @foreach (__('about.why_choose_us.items') as $card)
                        <article class="about-why-card">
                            <div class="about-why-card__icon">
                                <i class="bi {{ $whyIcons[$loop->index] ?? $whyIcons[0] }}" aria-hidden="true"></i>
                            </div>
                            <h3>{{ $card['title'] }}</h3>
                            <p>{{ $card['description'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-info" aria-labelledby="company-info-title">
            <div class="about-container">
                <h2 id="company-info-title" class="about-info__title">{{ __('about.company_info.title') }}</h2>
                <div class="about-data-table">
                    @foreach (__('about.company_info.rows') as $row)
                        <div class="about-data-table__row">
                            <div class="about-data-table__label">{{ $row['label'] }}</div>
                            <div class="about-data-table__value">
                                @foreach ($row['value'] as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <figure class="about-location-image">
                    <iframe title="{{ __('about.company_info.map_title') }}" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12972.809005114626!2d139.7786386!3d35.6227402!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8114b420fe355d44!2z44Ob44OD44OI44K544OI44Op44OD44OXICjjg6bjg7zjg7vjgqLjg7Pjg4njg7vjgqLjg7zjgrnmoKrlvI_kvJrnpL4p!5e0!3m2!1sja!2sjp!4v1487402168426" width="745" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                </figure>

                <figure class="about-location-image">
                    <img src="{{ asset('assets/images/about/tokyo_member.jpg') }}?v=2" alt="{{ __('about.company_info.image_alt') }}">
                </figure>
            </div>
        </section>

        <section class="about-production" aria-labelledby="production-title">
            <div class="about-container">
                <h2 id="production-title" class="about-info__title">{{ __('about.design_production.title') }}</h2>

                <div class="about-data-table about-data-table--production">
                    @foreach (__('about.design_production.rows') as $row)
                        <div class="about-data-table__row">
                            <div class="about-data-table__label">{{ $row['label'] }}</div>
                            <div class="about-data-table__value">
                                @foreach ($row['value'] as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <figure class="about-production-image">
                    <img src="{{ asset('assets/images/about/thailand-member.jpg') }}?v=12" alt="{{ __('about.design_production.image_alt') }}">
                </figure>
            </div>
        </section>

        <section class="about-factory" aria-labelledby="factory-title">
            <div class="about-container">
                <h2 id="factory-title" class="about-info__title">{{ __('about.factory_info.title') }}</h2>

                <div class="about-data-table about-data-table--factory">
                    @foreach (__('about.factory_info.rows') as $row)
                        <div class="about-data-table__row">
                            <div class="about-data-table__label">{{ $row['label'] }}</div>
                            <div class="about-data-table__value">
                                @foreach ($row['value'] as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <figure class="about-production-image">
                    <img src="{{ asset('assets/images/about/factory.jpg') }}?v=1" alt="{{ __('about.factory_info.image_alt') }}">
                </figure>
            </div>
        </section>

        <section class="about-factory" aria-labelledby="brazil-title">
            <div class="about-container">
                <h2 id="brazil-title" class="about-info__title">{{ __('about.brazil_branch.title') }}</h2>

                <div class="about-data-table about-data-table--factory">
                    @foreach (__('about.brazil_branch.rows') as $row)
                        <div class="about-data-table__row">
                            <div class="about-data-table__label">{{ $row['label'] }}</div>
                            <div class="about-data-table__value">
                                @foreach ($row['value'] as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <figure class="about-production-image">
                    <img src="{{ asset('assets/images/about/brazil_member.webp') }}?v=1" alt="{{ __('about.brazil_branch.image_alt') }}" style="height:auto !important;">
                </figure>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/about.js') }}?v={{ date('is') }}"></script>
@endsection
