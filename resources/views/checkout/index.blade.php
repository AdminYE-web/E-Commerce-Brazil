@extends('layouts.app')

@section('title', 'Checkout')

@section('css')
    <style>
        .checkout-page {
            background: #f5f6f8;
            padding: 30px 0 60px;
        }

        .checkout-stepper {
            max-width: 760px;
            margin: 0 auto 34px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
        }

        .checkout-stepper::before {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            right: 70px;
            height: 3px;
            background: #d9d9d9;
            z-index: 1;
        }

        .checkout-stepper::after {
            content: "";
            position: absolute;
            top: 25px;
            left: 70px;
            width: calc((100% - 140px) / 4);
            height: 3px;
            background: #48c26b;
            z-index: 2;
        }

        .checkout-step {
            position: relative;
            z-index: 3;
            width: 120px;
            text-align: center;
        }

        .step-circle {
            width: 52px;
            height: 52px;
            margin: 0 auto 8px;
            border-radius: 50%;
            border: 2px solid #d9d9d9;
            background: #f5f6f8;
            color: #a7b1c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 600;
        }

        .step-label {
            font-size: 15px;
            color: #9aa8bd;
            font-weight: 500;
        }

        .checkout-step.completed .step-circle {
            background: #48c26b;
            border-color: #48c26b;
            color: #fff;
            font-size: 30px;
            font-weight: 700;
        }

        .checkout-step.completed .step-label {
            color: #111;
            font-weight: 600;
        }

        .checkout-step.current .step-circle {
            background: #f5f6f8;
            border-color: #2f6fff;
            color: #2f6fff;
        }

        .checkout-step.current .step-label {
            color: #2f6fff;
            font-weight: 600;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 330px;
            gap: 28px;
            align-items: start;
        }

        .order-product-card {
            background: #fff;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .order-product-header {
            display: flex;
            gap: 14px;
            align-items: center;
            margin-bottom: 16px;
        }

        .order-product-image {
            width: 74px;
            height: 74px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .order-product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .order-product-category {
            font-size: 13px;
            color: #64748b;
        }

        .upload-artwork-box {
            position: relative;
            background: #f3f6fa;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748b;
            margin-bottom: 10px;
        }

        .upload-artwork-box input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            width: 34px;
            height: 34px;
            margin-bottom: 8px;
        }

        .upload-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .upload-artwork-box span {
            color: #2563eb;
            text-decoration: underline;
        }

        .upload-note {
            font-size: 12px;
            color: #ef4444;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .artwork-option-row,
        .artwork-field {
            margin-top: 12px;
        }

        .artwork-field label,
        .template-title {
            display: block;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .artwork-field input,
        .artwork-field select {
            width: 100%;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0 10px;
        }

        .artwork-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .template-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px;
            cursor: pointer;
            text-align: center;
        }

        .template-card input {
            display: none;
        }

        .template-card:has(input:checked) {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .template-image {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .template-image img {
            max-width: 100%;
            max-height: 56px;
            object-fit: contain;
        }

        .template-card span {
            font-size: 12px;
        }

        .checkout-summary {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            position: sticky;
            top: 20px;
        }

        .checkout-summary h3 {
            font-size: 22px;
            font-weight: 800;
        }

        .summary-line,
        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .summary-total {
            border-bottom: 0;
            font-size: 20px;
            font-weight: 800;
            margin-top: 10px;
        }

        .checkout-tip {
            background: #eef5ff;
            color: #2563eb;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin: 16px 0;
        }

        .checkout-next-btn,
        .checkout-back-btn {
            width: 100%;
            height: 42px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .checkout-next-btn {
            border: 0;
            background: #2563eb;
            color: #fff;
            font-weight: 700;
        }

        .checkout-back-btn {
            margin-top: 8px;
            border: 1px solid #d1d5db;
            color: #111;
            background: #fff;
        }

        .artwork-collapse-box {
            margin-top: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            overflow: hidden;
        }

        .artwork-collapse-toggle {
            width: 100%;
            height: 42px;
            border: 0;
            background: #f8fafc;
            padding: 0 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            cursor: pointer;
        }

        .artwork-collapse-arrow {
            width: 14px;
            height: 14px;
            object-fit: contain;
            transition: transform 0.25s ease;
        }

        .artwork-collapse-toggle.is-open .artwork-collapse-arrow {
            transform: rotate(180deg);
        }

        .artwork-collapse-content {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            padding: 0 14px;
            transition:
                max-height 0.35s ease,
                opacity 0.25s ease,
                padding 0.25s ease;
        }

        .artwork-collapse-content.is-open {
            max-height: 1200px;
            opacity: 1;
            padding: 14px;
        }

        .artwork-field {
            margin-bottom: 12px;
        }

        .artwork-field label,
        .template-title {
            display: block;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .artwork-field input,
        .artwork-field select {
            width: 100%;
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 0 10px;
        }

        .artwork-field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .template-section {
            margin-top: 8px;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .template-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            text-align: center;
        }

        .template-card input {
            display: none;
        }

        .template-card:has(input:checked) {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .template-image {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .template-image img {
            max-width: 100%;
            max-height: 64px;
            object-fit: contain;
        }

        .template-card span {
            display: block;
            font-size: 12px;
            margin-top: 8px;
        }

        @media (max-width: 768px) {
            .artwork-field-row {
                grid-template-columns: 1fr;
            }

            .template-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .upload-file-box {
            position: relative;
            min-height: 135px;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            background: #fff;
            padding: 22px 18px;
            margin-bottom: 10px;
        }

        .upload-file-box .artwork-file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .upload-empty-state {
            min-height: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748b;
            pointer-events: none;
        }

        .uploaded-file-state {
            position: relative;
            z-index: 3;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            pointer-events: auto;
        }

        .uploaded-file-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .uploaded-file-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            max-width: 360px;
            min-height: 34px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e6f0ff;
            color: #1f5fae;
            font-size: 16px;
            line-height: 1;
        }

        .uploaded-file-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .uploaded-file-icon img {
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        .uploaded-file-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .remove-uploaded-file {
            border: 0;
            background: transparent;
            color: #7b8794;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
            padding: 0;
            margin-left: 4px;
        }

        .add-more-file-btn {
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            white-space: nowrap;
        }

        .add-more-file-btn:hover {
            text-decoration: underline;
        }

        .uploaded-file-state {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            width: 100%;
        }

        .uploaded-file-list {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            min-width: 0;
        }

        .uploaded-file-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            max-width: 360px;
            min-height: 36px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e6f0ff;
            color: #1f5fae;
            font-size: 16px;
            line-height: 1;
        }

        .uploaded-file-name {
            display: inline-block;
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .add-more-file-btn {
            flex-shrink: 0;
            align-self: flex-start;
            border: 0;
            background: transparent;
            color: #2563eb;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            margin-top: 3px;
            white-space: nowrap;
        }
        @media (max-width: 991.98px) {
    .checkout-layout {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .checkout-summary {
        position: static;
        top: auto;
    }

    .checkout-stepper {
        max-width: 100%;
        padding: 0 10px;
    }
}

@media (max-width: 768px) {
   
    .checkout-page {
        padding: 18px 0 36px;
    }

    .checkout-stepper {
        margin-bottom: 20px;
    }

    .checkout-stepper::before,
    .checkout-stepper::after {
        top: 18px;
        left: 38px;
        right: 38px;
    }

    .checkout-step {
        width: 72px;
    }

    .step-circle {
        width: 38px;
        height: 38px;
        font-size: 16px;
        margin-bottom: 6px;
    }

    .checkout-step.completed .step-circle {
        font-size: 22px;
    }

    .step-label {
        font-size: 11px;
        line-height: 1.2;
    }

    .order-product-card {
        padding: 14px;
        border-radius: 10px;
        margin-bottom: 14px;
    }

    .order-product-header {
        gap: 12px;
        align-items: flex-start;
    }

    .order-product-image {
        width: 72px;
        height: 72px;
        flex-shrink: 0;
    }

    .order-product-category {
        font-size: 12px;
    }

    .order-product-header strong {
        display: block;
        font-size: 14px;
        line-height: 1.25;
        margin-bottom: 4px;
    }

    .order-product-header div {
        font-size: 13px;
    }

    .upload-file-box {
        min-height: 118px;
        padding: 18px 12px;
    }

    .upload-empty-state p {
        font-size: 13px;
        text-align: center;
        margin: 0;
        line-height: 1.4;
    }

    .upload-note {
        font-size: 11px;
    }

    .artwork-collapse-toggle {
        height: 40px;
        font-size: 13px;
        padding: 0 12px;
    }

    .artwork-collapse-content.is-open {
        padding: 12px;
    }

    .artwork-field-row {
        grid-template-columns: 1fr;
        gap: 8px;
    }

    .template-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .template-card {
        padding: 8px;
    }

    .template-image {
        height: 58px;
    }

    .template-card span {
        font-size: 11px;
    }

    .uploaded-file-state {
        flex-direction: column;
        gap: 12px;
    }

    .uploaded-file-pill {
        max-width: 100%;
        width: 100%;
        font-size: 13px;
    }

    .uploaded-file-name {
        max-width: 190px;
    }

    .add-more-file-btn {
        font-size: 13px;
    }

    .checkout-summary {
        padding: 18px;
        border-radius: 10px;
    }

    .checkout-summary h3 {
        font-size: 20px;
    }

    .summary-line {
        font-size: 13px;
    }

    .summary-total {
        font-size: 18px;
    }

    .checkout-next-btn,
    .checkout-back-btn {
        height: 40px;
        font-size: 13px;
    }
}

@media (max-width: 420px) {
    .checkout-step {
        width: 62px;
    }

    .step-label {
        font-size: 10px;
    }

    .checkout-stepper::before,
    .checkout-stepper::after {
        left: 32px;
        right: 32px;
    }

    .template-grid {
        grid-template-columns: 1fr;
    }
}
    </style>
@endsection


@section('content')
 
    <form action="{{ route('checkout.storeArtworkStep') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="checkout-page">
            <div class="container">

              @include('checkout.partials.stepper', ['currentStep' => 2])

                <div class="checkout-layout">

                    <div class="checkout-left">
                        @foreach ($cart as $cartItemId => $item)
                            @php
                                $product = $products[$item['product_id']] ?? null;
                            @endphp

                            <div class="order-product-card">
                                <div class="order-product-header">
                                    <div class="order-product-image">
                                        @if (!empty($item['product_image']))
                                            <img src="{{ asset('storage/' . $item['product_image']) }}"
                                                alt="{{ $item['product_name'] }}">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="No image">
                                        @endif
                                    </div>

                                    <div>
                                        <div class="order-product-category">Cordão</div>
                                        <strong>{{ $item['product_name'] }}</strong>
                                        <div>Qtd : {{ $item['quantity'] }}</div>
                                    </div>
                                </div>

                                @if ($product && $product->can_upload_artwork)
                                    <div class="upload-artwork-box upload-file-box" data-cart-item-id="{{ $cartItemId }}">
                                        <input type="file" name="artwork_files[{{ $cartItemId }}][]"
                                            class="artwork-file-input" multiple
                                            accept=".ai,.pdf,.jpeg,.jpg,.png,.psd,.zip,.eps">

                                        <div class="upload-empty-state">
                                            <div class="upload-icon">
                                                <img src="{{ asset('assets/images/icon/upload-icon.png') }}" alt="">
                                            </div>

                                            <p>
                                                Arraste e solte seu arquivo aqui ou
                                                <span>clique para selecionar</span>
                                            </p>
                                        </div>

                                        <div class="uploaded-file-state" style="display:none;">
                                            <div class="uploaded-file-list"></div>

                                            <button type="button" class="add-more-file-btn">
                                                Adicionar mais
                                            </button>
                                        </div>
                                    </div>

                                    <div class="upload-note">
                                        * Você pode enviar arquivos nos seguintes formatos: AI, PDF, JPEG, JPG, PSD, ZIP e
                                        EPS.<br>
                                        * Arquivos maiores que 10MB não podem ser enviados.
                                    </div>

                                    @if ($product->allow_no_artwork)
                                        <div class="artwork-option-row">
                                            <label>
                                                <input type="checkbox" name="no_artwork[{{ $cartItemId }}]"
                                                    value="1">
                                                Não tenho arquivo agora
                                            </label>
                                        </div>
                                    @endif

                                    @if (
                                        $product->allow_text_print ||
                                            $product->allow_font_select ||
                                            ($product->allow_template_select && $product->artworkTemplates->count()))
                                        <div class="artwork-collapse-box">
                                            <button type="button" class="artwork-collapse-toggle is-open"
                                                data-target-id="artwork-customize-{{ $cartItemId }}">
                                                <span>{{ __('checkout.step_2.adjust_template') }}</span>
                                                <img class="artwork-collapse-arrow"
                                                    src="{{ asset('assets/images/icon/arrow-icon.png') }}" alt="">
                                            </button>

                                            <div class="artwork-collapse-content is-open"
                                                id="artwork-customize-{{ $cartItemId }}">
                                                @if ($product->allow_text_print)
                                                    <div class="artwork-field">
                                                        <label>{{ __('checkout.step_2.text') }}</label>
                                                        <input type="text" name="print_text[{{ $cartItemId }}]"
                                                            placeholder="{{ __('checkout.step_2.text_place') }}">
                                                    </div>
                                                @endif

                                                @if ($product->allow_font_select)
                                                    <div class="artwork-field">
                                                        <label>{{ __('checkout.step_2.font') }}</label>

                                                        <div class="artwork-field-row">
                                                            <select name="font_option[{{ $cartItemId }}]">
                                                                <option value="">Selecione uma fonte</option>
                                                                <option value="arial">Arial</option>
                                                                <option value="times_new_roman">Times New Roman</option>
                                                                <option value="outro">Outro</option>
                                                            </select>

                                                            <input type="text" name="font_other[{{ $cartItemId }}]"
                                                                placeholder="{{ __('checkout.step_2.font_place') }}">
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($product->allow_template_select && $product->artworkTemplates->count())
                                                    <div class="template-section">
                                                        <div class="template-title">{{ __('checkout.step_2.template') }} ⓘ</div>

                                                        @php
                                                            $selectedTemplateId = session(
                                                                "checkout_artworks.$cartItemId.template_id",
                                                            );
                                                        @endphp

                                                        <div class="template-grid">
                                                            @foreach ($product->artworkTemplates as $template)
                                                                <label class="template-card">
                                                                    <input type="radio"
                                                                        name="template_id[{{ $cartItemId }}]"
                                                                        value="{{ $template->template_id }}"
                                                                        {{ $selectedTemplateId
                                                                            ? ((int) $selectedTemplateId === (int) $template->template_id
                                                                                ? 'checked'
                                                                                : '')
                                                                            : ($loop->first
                                                                                ? 'checked'
                                                                                : '') }}>

                                                                    <div class="template-image">
                                                                        @if ($template->image_path)
                                                                            <img src="{{ asset('storage/' . $template->image_path) }}"
                                                                                alt="{{ $template->template_name }}">
                                                                        @else
                                                                            <span>No image</span>
                                                                        @endif
                                                                    </div>

                                                                    <span>{{ $template->template_name }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="no-upload-needed">
                                       
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                     @include('checkout.partials.summary-sidebar', [
                    'backRoute' => route('cart.index'),
                    'backText' => __('checkout.step_2.goback_cart'),
                    'nextText' => __('checkout.step_2.gonext_step'),
                ])

                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.artwork-collapse-toggle').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.targetId;
                    const target = document.getElementById(targetId);

                    if (!target) {
                        console.log('Target not found:', targetId);
                        return;
                    }

                    target.classList.toggle('is-open');
                    this.classList.toggle('is-open');
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.upload-file-box').forEach(function(box) {
                const input = box.querySelector('.artwork-file-input');
                const emptyState = box.querySelector('.upload-empty-state');
                const uploadedState = box.querySelector('.uploaded-file-state');
                const fileList = box.querySelector('.uploaded-file-list');
                const addMoreBtn = box.querySelector('.add-more-file-btn');

                let selectedFiles = [];

                function getFileIcon(filename) {
                    const ext = filename.split('.').pop().toLowerCase();

                    if (ext === 'ai') {
                        return "{{ asset('assets/images/icon/file-ai.png') }}";
                    }

                    if (ext === 'pdf') {
                        return "{{ asset('assets/images/icon/file-pdf.png') }}";
                    }

                    if (['jpg', 'jpeg', 'png', 'webp'].includes(ext)) {
                        return "{{ asset('assets/images/icon/file-image.png') }}";
                    }

                    if (ext === 'zip') {
                        return "{{ asset('assets/images/icon/file-zip.png') }}";
                    }

                    return "{{ asset('assets/images/icon/file-default.png') }}";
                }

                function syncInputFiles() {
                    const dataTransfer = new DataTransfer();

                    selectedFiles.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });

                    input.files = dataTransfer.files;
                }

                function renderFiles() {
                    fileList.innerHTML = '';

                    if (selectedFiles.length === 0) {
                        emptyState.style.display = 'flex';
                        uploadedState.style.display = 'none';
                        return;
                    }

                    emptyState.style.display = 'none';
                    uploadedState.style.display = 'flex';

                    selectedFiles.forEach(function(file, index) {
                        const item = document.createElement('div');
                        item.className = 'uploaded-file-pill';

                        item.innerHTML = `
                    <span class="uploaded-file-icon">
                        <img src="${getFileIcon(file.name)}" alt="">
                    </span>

                    <span class="uploaded-file-name">${file.name}</span>

                    <button type="button" class="remove-uploaded-file" data-index="${index}">
                        ×
                    </button>
                `;

                        fileList.appendChild(item);
                    });

                    syncInputFiles();
                }

                input.addEventListener('change', function() {
                    const newFiles = Array.from(input.files);

                    newFiles.forEach(function(file) {
                        const exists = selectedFiles.some(function(existingFile) {
                            return existingFile.name === file.name &&
                                existingFile.size === file.size &&
                                existingFile.lastModified === file.lastModified;
                        });

                        if (!exists) {
                            selectedFiles.push(file);
                        }
                    });

                    renderFiles();
                });

                addMoreBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    input.click();
                });

                fileList.addEventListener('click', function(e) {
                    if (!e.target.classList.contains('remove-uploaded-file')) {
                        return;
                    }

                    e.stopPropagation();

                    const index = parseInt(e.target.dataset.index);

                    selectedFiles.splice(index, 1);

                    renderFiles();
                });
            });
        });
    </script>
@endsection
