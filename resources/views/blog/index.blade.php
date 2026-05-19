@extends('layouts.app')

@section('title', 'Blog')

@section('css')
<style>
    .blog-page {
        background: #fff;
        padding: 38px 16px 70px;
    }

    .blog-container {
        max-width: 1180px;
        margin: 0 auto;
    }

    .blog-breadcrumb {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 10px;
    }

    .blog-breadcrumb a {
        color: inherit;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .blog-breadcrumb-icon {
        width: 16px;
        height: 16px;
        object-fit: contain;
        display: block;
    }

    .blog-title {
        margin: 0;
        font-size: 64px;
        line-height: 1.05;
        font-weight: 600;
        color: #111;
    }

    .blog-desc {
        margin: 10px 0 4px;
        font-size: 16px;
        font-weight: 600;
        color: #111;
    }

    .blog-update {
        color: #9ca3af;
        font-size: 16px;
        margin-bottom: 24px;
    }

    .blog-filter-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 38px;
    }

    .blog-category-tabs {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .blog-tab {
        min-width: 96px;
        height: 34px;
        padding: 0 18px;
        border: 1px solid #ccd3dd;
        border-radius: 999px;
        background: #fff;
        color: #111;
        text-decoration: none;
        font-size: 16px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
    }

    .blog-tab:hover,
    .blog-tab.is-active {
        background: #123f78;
        border-color: #123f78;
        color: #fff;
    }

    .blog-sort-dropdown {
        width: 235px;
    }

    .blog-sort-toggle {
        width: 100%;
        height: 48px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0 12px 0 18px;
        background: #fff;
        color: #111;
        font-size: 16px;
        font-weight: 500;
        outline: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .blog-sort-toggle:hover,
    .blog-sort-toggle:focus,
    .blog-sort-toggle.show {
        background: #fff;
        border-color: #d1d5db;
        color: #111;
        box-shadow: none;
    }

    .blog-sort-icon {
        font-size: 13px;
        transition: transform .18s ease;
    }

    .blog-sort-toggle.show .blog-sort-icon {
        transform: rotate(180deg);
    }

    .blog-sort-menu {
        width: 100%;
        min-width: 100%;
        margin-top: 12px !important;
        padding: 0;
        border: 0;
        border-radius: 0;
        background: #fff;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .08);
        overflow: hidden;
    }

    .blog-sort-item {
        width: 100%;
        height: 56px;
        padding: 0 20px;
        border: 0;
        background: #fff;
        color: #111;
        font-size: 14px;
        font-weight: 500;
        text-align: left;
        display: flex;
        align-items: center;
    }

    .blog-sort-item:hover,
    .blog-sort-item:focus {
        background: #f8fafc;
        color: #111;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 34px 44px;
    }

    .blog-card {
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: .2s ease;
    }

    .blog-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.08);
    }

    .blog-card-image {
        width: 100%;
        height: 150px;
        background: #ddd;
        overflow: hidden;
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .3s ease;
    }

    .blog-card:hover .blog-card-image img {
        transform: scale(1.04);
    }

    .blog-card-body {
        padding: 14px 16px 12px;
    }

    .blog-card-title {
        margin: 0 0 7px;
        color: #111;
        font-size: 18px;
        font-weight: 500;
        line-height: 1.3;
    }

    .blog-card-excerpt {
        color: #111;
        font-size: 14px;
        line-height: 1.45;
        min-height: 50px;
        margin-bottom: 14px;
    }

    .blog-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .blog-category-pill {
        min-width: 74px;
        height: 20px;
        padding: 0 12px;
        border-radius: 999px;
        background: #89d5d0;
        color: #0f4e55;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .blog-card:nth-child(3n+2) .blog-category-pill {
        background: #f4d36f;
        color: #5d4300;
    }

    .blog-card:nth-child(3n) .blog-category-pill {
        background: #8ed0e9;
        color: #164b60;
    }

    .blog-date {
        color: #a3a3a3;
        font-size: 11px;
    }

    .blog-pagination {
        margin-top: 44px;
        display: flex;
        justify-content: center;
    }

    .blog-pagination nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 28px;
        color: #183f78;
        font-size: 16px;
        font-weight: 500;
    }

    .blog-page-link,
    .blog-page-current,
    .blog-page-disabled,
    .blog-page-ellipsis {
        min-width: 27px;
        height: 27px;
        padding: 0 8px;
        border-radius: 5px;
        color: #000;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .blog-page-prev,
    .blog-page-next {
        min-width: auto;
        color: #183f78;
        padding: 0;
        gap: 4px;
    }

    .blog-page-current {
        background: #183f78;
        color: #fff;
        box-shadow: 0 2px 5px rgba(24, 63, 120, .2);
    }

    .blog-page-disabled {
        color: #9ca3af;
    }

    .blog-page-ellipsis {
        color: #000;
    }

    .blog-empty {
        grid-column: 1 / -1;
        text-align: center;
        color: #777;
        padding: 60px 0;
    }

    @media (max-width: 900px) {
        .blog-title {
            font-size: 38px;
        }

        .blog-filter-row {
            flex-direction: column;
            align-items: stretch;
        }

        .blog-sort-dropdown {
            width: 100%;
        }

        .blog-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }
    }

    @media (max-width: 600px) {
        .blog-grid {
            grid-template-columns: 1fr;
        }

        .blog-tab {
            min-width: auto;
            flex: 1;
        }

        .blog-pagination nav {
            gap: 10px;
            font-size: 16px;
            flex-wrap: wrap;
        }

        .blog-page-link,
        .blog-page-current,
        .blog-page-disabled,
        .blog-page-ellipsis {
            min-width: 34px;
            height: 34px;
        }
    }
</style>
@endsection

@section('content')

<section class="blog-page">
    <div class="blog-container">

        <div class="blog-breadcrumb">
            <a href="{{ route('blog.index') }}">
                <img src="{{ asset('assets/images/icon/ci_house-01.png') }}" alt="" class="blog-breadcrumb-icon">
                <span>/ Blog</span>
            </a>
        </div>

        <h1 class="blog-title">Blog</h1>

        <div class="blog-desc">
            Informação de qualidade, curada especialmente para você.
        </div>

        <div class="blog-update">
            Última atualização:
            {{ optional($articles->first())->article_date ? \Carbon\Carbon::parse($articles->first()->article_date)->format('M Y') : now()->format('M Y') }}
        </div>

        <div class="blog-filter-row">
            <div class="blog-category-tabs">
                <a href="{{ route('blog.index', ['sort' => $sort]) }}"
                   class="blog-tab {{ empty($category) ? 'is-active' : '' }}">
                    Todos
                </a>

                @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat, 'sort' => $sort]) }}"
                       class="blog-tab {{ $category === $cat ? 'is-active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('blog.index') }}" class="blog-sort-dropdown dropdown">
                @if($category)
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif

                <button class="blog-sort-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>{{ $sort === 'oldest' ? 'Mais antigos' : 'Mais recentes' }}</span>
                    <i class="bi bi-chevron-down blog-sort-icon" aria-hidden="true"></i>
                </button>
                <div class="blog-sort-menu dropdown-menu">
                    <button class="blog-sort-item" type="submit" name="sort" value="latest">
                        Mais recentes
                    </button>
                    <button class="blog-sort-item" type="submit" name="sort" value="oldest">
                        Mais antigos
                    </button>
                </div>
            </form>
        </div>

        <div class="blog-grid">
            @forelse($articles as $article)
                <a href="{{ route('blog.show', $article->article_id) }}" class="blog-card">
                    <div class="blog-card-image">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
                        @endif
                    </div>

                    <div class="blog-card-body">
                        <h2 class="blog-card-title">
                            {{ $article->title }}
                        </h2>

                        <div class="blog-card-excerpt">
                            {{ \Illuminate\Support\Str::limit($article->description ?: strip_tags($article->detail), 95) }}
                        </div>

                        <div class="blog-card-footer">
                            <span class="blog-category-pill">
                                {{ $article->category ?? 'Blog' }}
                            </span>

                            <span class="blog-date">
                                {{ $article->article_date ? \Carbon\Carbon::parse($article->article_date)->format('d/m/Y') : $article->created_at?->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="blog-empty">
                    No articles found.
                </div>
            @endforelse
        </div>

        <div class="blog-pagination">
            {{ $articles->links('vendor.pagination.blog') }}
        </div>

    </div>
</section>

@endsection
