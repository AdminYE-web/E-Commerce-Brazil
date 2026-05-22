@extends('layouts.app')

@section('title', 'Design Template')

@section('css')
    <style>
        .template-download-page {
            background: #fff;
            padding: 34px 16px 80px;
        }

        .template-download-container {
            max-width: 760px;
            margin: 0 auto;
        }

        .template-breadcrumb {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 26px;
        }

        .template-page-title {
            text-align: center;
            color: #0b2d68;
            font-size: 26px;
            font-weight: 800;
            margin: 0 0 26px;
        }

        .template-type-tabs {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-bottom: 28px;
        }

        .template-type-tab {
            width: 150px;
            height: 88px;
            border: 1px solid #d7dde8;
            border-radius: 8px;
            background: #fff;
            color: #111;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            transition: .2s ease;
        }

        .template-type-tab img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .template-type-tab.is-active {
            background: #223a8f;
            border-color: #223a8f;
            color: #fff;
            box-shadow: 0 8px 20px rgba(34, 58, 143, 0.25);
        }

        .template-filter-form {
            margin-top: 18px;
        }

        .template-form-group {
            margin-bottom: 14px;
        }

        .template-form-group label {
            display: block;
            font-size: 12px;
            color: #111;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .template-select {
            width: 100%;
            height: 38px;
            border: 1px solid #d7dde8;
            border-radius: 4px;
            background: #f8fafc;
            padding: 0 12px;
            font-size: 13px;
            color: #111;
            outline: none;
        }

        .template-select:focus {
            border-color: #223a8f;
            background: #fff;
        }

        .template-result {
            margin-top: 34px;
        }

        .template-result-title {
            color: #0b2d68;
            font-size: 20px;
            font-weight: 800;
            margin: 0 0 16px;
        }

        .template-file-group {
            margin-bottom: 24px;
        }

        .template-file-type-title {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #e5e5e5;
            border-radius: 5px;
            padding: 7px 12px;
            color: #111;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .template-file-type-title img {
            width: 16px;
            height: 16px;
            object-fit: contain;
        }

        .template-file-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .template-file-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 9px;
            font-size: 13px;
        }

        .template-file-item img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .template-file-item a {
            color: #555;
            text-decoration: underline;
        }

        .template-file-item a:hover {
            color: #0b2d68;
        }

        .template-empty {
            margin-top: 28px;
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #777;
            font-size: 14px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .template-type-tabs {
                gap: 10px;
            }

            .template-type-tab {
                width: 50%;
            }

            .template-page-title {
                font-size: 22px;
            }
        }

        .template-file-tabs {
            width: 100%;
            height: 32px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            align-items: center;
            background: #d9d9d9;
            border-radius: 6px;
            overflow: hidden;
            margin: 0 0 22px;
            padding: 1px;
        }

        .template-file-tab {
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #111;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 0;
            margin: 0;
            appearance: none;
            -webkit-appearance: none;
        }

        .template-file-tab.is-active {
            background: #fff;
            border-radius: 6px;
        }

        .template-file-tab img {
            width: 14px;
            height: 14px;
            object-fit: contain;
            display: block;
        }

        .template-file-panel {
            display: none;
        }

        .template-file-panel.is-active {
            display: block;
        }
    </style>
@endsection

@section('content')

    <section class="template-download-page">
        <div class="template-download-container">

            <div class="template-breadcrumb">
                ⌂ / {{ __('product.design_template.title') }}
            </div>

            <h1 class="template-page-title">
                {{ __('product.design_template.download_template') }}
            </h1>

            <div class="template-type-tabs">
                @foreach ($productTypes as $typeId => $type)
                    <a href="{{ route('design-template.index', ['type' => $typeId]) }}"
                        class="template-type-tab {{ (int) $selectedType === (int) $typeId ? 'is-active' : '' }}">
                        <img src="{{ $type['icon'] }}" alt="">
                        <span>{{ $type['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('design-template.index') }}" class="template-filter-form">
                <input type="hidden" name="type" value="{{ $selectedType }}">

                <div class="template-form-group">
                    <label>{{ __('product.design_template.select_product') }}</label>
                    <select name="product_id" class="template-select" onchange="this.form.submit()">
                        <option value="">{{ __('product.design_template.select_product_option') }}</option>

                        @foreach ($products as $product)
                            <option value="{{ $product->product_id }}"
                                {{ (int) $selectedProductId === (int) $product->product_id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($sizes->count() > 0)
                    <div class="template-form-group">
                        <label>{{ __('product.design_template.width') }}</label>

                        <select name="size" class="template-select" onchange="this.form.submit()">
                            <option value="">{{ __('product.design_template.select_product_option') }}</option>

                            @foreach ($sizes as $size)
                                <option value="{{ $size }}" {{ $selectedSize === $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </form>

            @if ($selectedProductId && ($sizes->count() === 0 || $selectedSize))
                @php
                    $selectedProduct = $products->firstWhere('product_id', (int) $selectedProductId);
                    $groupedTemplates = $templates->groupBy('file_type');
                @endphp

                <div class="template-result">
                    <h2 class="template-result-title">
                        {{ $selectedProduct->product_name ?? __('product.design_template.template') }}
                        @if ($sizes->count() > 0 && $selectedSize)
                            - {{ $selectedSize }}
                        @endif
                        ( AI, PDF )
                    </h2>

                    @php
                        $aiFiles = $templates->where('file_type', 'ai');
                        $pdfFiles = $templates->where('file_type', 'pdf');
                    @endphp

                    @if ($templates->count() > 0)
                        <div class="template-file-tabs">
                            <button type="button" class="template-file-tab is-active" data-file-tab="ai">
                                <img src="{{ asset('assets/images/icon/image 318.png') }}" alt="">
                                <span>File .Ai</span>
                            </button>

                            <button type="button" class="template-file-tab" data-file-tab="pdf">
                                <img src="{{ asset('assets/images/icon/image-Photoroom (11) 2.png') }}" alt="">
                                <span>File .PDF</span>
                            </button>
                        </div>

                        <div class="template-file-panel is-active" data-file-panel="ai">
                            @if ($aiFiles->count() > 0)
                                <ul class="template-file-list">
                                    @foreach ($aiFiles as $template)
                                        <li class="template-file-item">
                                            <img src="{{ asset('assets/images/icon/image 318.png') }}" alt="">

                                            <a href="{{ asset('storage/' . $template->file_path) }}" download>
                                                {{ $template->original_name ?? basename($template->file_path) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="template-file-empty">
                                    No AI files found.
                                </div>
                            @endif
                        </div>

                        <div class="template-file-panel" data-file-panel="pdf">
                            @if ($pdfFiles->count() > 0)
                                <ul class="template-file-list">
                                    @foreach ($pdfFiles as $template)
                                        <li class="template-file-item">
                                            <img src="{{ asset('assets/images/icon/image-Photoroom (11) 2.png') }}"
                                                alt="">

                                            <a href="{{ asset('storage/' . $template->file_path) }}" download>
                                                {{ $template->original_name ?? basename($template->file_path) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="template-file-empty">
                                    No PDF files found.
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="template-empty">
                            {{ __('product.design_template.no_template_found') }}
                        </div>
                    @endif
                </div>
            @else
                <div class="template-empty">
                    {{ __('product.design_template.select_product_and_size_to_download_template_files') }}
                </div>
            @endif

        </div>
    </section>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.template-file-tab');
            const panels = document.querySelectorAll('.template-file-panel');

            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    const target = this.dataset.fileTab;

                    tabs.forEach(function(item) {
                        item.classList.remove('is-active');
                    });

                    panels.forEach(function(panel) {
                        panel.classList.remove('is-active');
                    });

                    this.classList.add('is-active');

                    const targetPanel = document.querySelector('[data-file-panel="' + target +
                        '"]');

                    if (targetPanel) {
                        targetPanel.classList.add('is-active');
                    }
                });
            });
        });
    </script>
@endsection
