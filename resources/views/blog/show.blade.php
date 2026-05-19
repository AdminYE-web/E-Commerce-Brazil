@extends('layouts.app')

@section('title', $article->title)

@section('css')
<style>
    .blog-detail-page {
        background: #fff;
        padding: 34px 16px 80px;
    }

    .blog-detail-container {
        max-width: 980px;
        margin: 0 auto;
    }

    .blog-detail-breadcrumb {
        color: #17439a;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .blog-detail-breadcrumb a {
        color: #17439a;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .blog-detail-breadcrumb-icon {
        width: 16px;
        height: 16px;
        object-fit: contain;
        display: block;
    }

    .blog-detail-header {
        text-align: center;
        margin-bottom: 34px;
    }

    .blog-detail-title {
        max-width: 820px;
        margin: 0 auto 16px;
        color: #111;
        font-size: 34px;
        line-height: 1.35;
        font-weight: 800;
    }

    .blog-detail-meta {
        color: #9ca3af;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .blog-detail-category {
        min-width: 86px;
        height: 24px;
        padding: 0 14px;
        border-radius: 999px;
        background: #89d5d0;
        color: #0f4e55;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .blog-detail-cover {
        max-width: 650px;
        margin: 34px auto 38px;
        border-radius: 4px;
        overflow: hidden;
        background: #f1f1f1;
    }

    .blog-detail-cover img {
        width: 100%;
        display: block;
    }

    .blog-detail-content {
        max-width: 760px;
        margin: 0 auto;
        color: #111;
        font-size: 15px;
        line-height: 1.85;
    }

    .blog-detail-content h1,
    .blog-detail-content h2,
    .blog-detail-content h3 {
        margin: 34px 0 14px;
        color: #111;
        font-weight: 800;
        line-height: 1.35;
    }

    .blog-detail-content h2 {
        font-size: 22px;
    }

    .blog-detail-content h3 {
        font-size: 18px;
    }

    .blog-detail-content p {
        margin: 0 0 18px;
    }

    .blog-detail-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 26px auto;
        border-radius: 4px;
    }

    .blog-detail-content figure {
        margin: 26px 0;
    }

    .blog-detail-content ul,
    .blog-detail-content ol {
        margin: 0 0 20px 24px;
    }

    .blog-detail-content blockquote {
        margin: 24px 0;
        padding: 16px 20px;
        border-left: 4px solid #17439a;
        background: #f8fafc;
        color: #333;
    }

    .blog-detail-back {
        max-width: 760px;
        margin: 46px auto 0;
    }

    .blog-detail-back a {
        color: #17439a;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }

    .blog-detail-back a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .blog-detail-title {
            font-size: 26px;
        }

        .blog-detail-breadcrumb {
            margin-bottom: 26px;
        }

        .blog-detail-content {
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')

<section class="blog-detail-page">
    <div class="blog-detail-container">

        <div class="blog-detail-breadcrumb">
            <a href="{{ route('blog.index') }}">
                <img src="{{ asset('assets/images/icon/ci_house-01.png') }}" alt="" class="blog-detail-breadcrumb-icon">
                <span>/ Blog</span>
            </a>
            /
            {{ $article->title }}
        </div>

        <div class="blog-detail-header">
            <h1 class="blog-detail-title">
                {{ $article->title }}
            </h1>

            <div class="blog-detail-meta">
                更新日
                {{ $article->article_date ? \Carbon\Carbon::parse($article->article_date)->format('Y年 m月 d日') : $article->created_at?->format('Y年 m月 d日') }}
            </div>

            <div class="blog-detail-category">
                {{ $article->category ?? 'Blog' }}
            </div>
        </div>

        {{-- @if($article->cover_image)
            <div class="blog-detail-cover">
                <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}">
            </div>
        @endif --}}

        <article class="blog-detail-content">
            {!! $article->detail !!}
        </article>

        <div class="blog-detail-back">
            <a href="{{ route('blog.index') }}">
                ← Back to Blog
            </a>
        </div>

    </div>
</section>

@endsection
