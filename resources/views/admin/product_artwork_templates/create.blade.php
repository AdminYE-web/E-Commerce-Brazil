@extends('admin.layouts.app')

@section('title', 'Add Product Artwork Templates | Indigo Admin')

@section('css')
<style>
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .form-header h1 {
        margin: 0 0 6px;
        font-size: 24px;
        color: var(--fg-dark);
    }

    .form-header p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--fg-dark);
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group select {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
        font-family: inherit;
        background: #fff;
        color: var(--fg);
    }

    .section-title {
        margin: 28px 0 16px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .template-item {
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 18px;
        background: #fff;
    }

    .template-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .template-header h4 {
        margin: 0;
        font-size: 16px;
        color: var(--fg-dark);
    }

    .template-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .checkbox-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 12px;
        font-size: 14px;
    }

    .btn-outline,
    .btn-primary,
    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
        border: 1px solid transparent;
    }

    .btn-outline {
        background: #fff;
        border-color: var(--border);
        color: var(--fg);
    }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .btn-danger {
        background: #fff1f2;
        border-color: #fecdd3;
        color: #e11d48;
    }

    .add-template-btn {
        margin-top: 8px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }

    .alert-error {
        margin-bottom: 18px;
        padding: 12px 16px;
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    @media (max-width: 900px) {
        .template-grid {
            grid-template-columns: 1fr;
        }

        .form-header {
            flex-direction: column;
        }

        .template-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>
@endsection

@section('content')

<div class="form-card">
    <div class="form-header">
        <div>
            <h1>Add Product Artwork Templates</h1>
            <p>Create multiple artwork templates for products.</p>
        </div>

        <a href="{{ route('admin.product-artwork-templates.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.product-artwork-templates.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="section-title">Product Information</div>

        <div class="form-group">
            <label>Product</label>

            <select name="product_id" required>
                <option value="">-- Select Product --</option>

                @foreach($products as $product)
                    <option value="{{ $product->product_id }}"
                        {{ old('product_id') == $product->product_id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="section-title">Artwork Templates</div>

        <div id="template-wrapper">
            @php
                $oldTemplates = old('templates', [
                    [
                        'template_name' => '',
                        'sort_order' => 0,
                        'is_active' => 1,
                    ]
                ]);
            @endphp

            @foreach($oldTemplates as $index => $template)
                <div class="template-item">
                    <div class="template-header">
                        <h4>
                            Template
                            <span class="template-number">{{ $index + 1 }}</span>
                        </h4>

                        <button type="button" class="btn-danger remove-template">
                            Remove
                        </button>
                    </div>

                    <div class="template-grid">
                        <div class="form-group">
                            <label>Template Name</label>

                            <input
                                type="text"
                                name="templates[{{ $index }}][template_name]"
                                value="{{ $template['template_name'] ?? '' }}"
                                placeholder="เช่น No artwork template"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Template Image</label>

                            <input
                                type="file"
                                name="templates[{{ $index }}][image_path]"
                                accept="image/*"
                            >
                            <small>recommend the size 200x200.</small>
                        </div>

                        <div class="form-group">
                            <label>Sort Order</label>

                            <input
                                type="number"
                                name="templates[{{ $index }}][sort_order]"
                                value="{{ $template['sort_order'] ?? 0 }}"
                                min="0"
                            >
                        </div>

                        <div class="form-group">
                            <label>Status</label>

                            <div class="checkbox-box">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="templates[{{ $index }}][is_active]"
                                        value="1"
                                        {{ ($template['is_active'] ?? 1) ? 'checked' : '' }}
                                    >
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-template" class="btn-outline add-template-btn">
            + Add Template
        </button>

        <div class="form-actions">
            <a href="{{ route('admin.product-artwork-templates.index') }}" class="btn-outline">
                Cancel
            </a>

            <button type="submit" class="btn-primary">
                Save All Templates
            </button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    let templateIndex = document.querySelectorAll('.template-item').length;

    document.getElementById('add-template').addEventListener('click', function () {
        const wrapper = document.getElementById('template-wrapper');

        const html = `
            <div class="template-item">
                <div class="template-header">
                    <h4>
                        Template
                        <span class="template-number">${templateIndex + 1}</span>
                    </h4>

                    <button type="button" class="btn-danger remove-template">
                        Remove
                    </button>
                </div>

                <div class="template-grid">
                    <div class="form-group">
                        <label>Template Name</label>

                        <input
                            type="text"
                            name="templates[${templateIndex}][template_name]"
                            placeholder="เช่น No artwork template"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>Template Image</label>

                        <input
                            type="file"
                            name="templates[${templateIndex}][image_path]"
                            accept="image/*"
                        >
                    </div>

                    <div class="form-group">
                        <label>Sort Order</label>

                        <input
                            type="number"
                            name="templates[${templateIndex}][sort_order]"
                            value="0"
                            min="0"
                        >
                    </div>

                    <div class="form-group">
                        <label>Status</label>

                        <div class="checkbox-box">
                            <label>
                                <input
                                    type="checkbox"
                                    name="templates[${templateIndex}][is_active]"
                                    value="1"
                                    checked
                                >
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);

        templateIndex++;
        updateTemplateNumbers();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-template')) {

            const items = document.querySelectorAll('.template-item');

            if (items.length <= 1) {
                alert('ต้องมีอย่างน้อย 1 template');
                return;
            }

            e.target.closest('.template-item').remove();

            updateTemplateNumbers();
        }
    });

    function updateTemplateNumbers() {
        document.querySelectorAll('.template-item').forEach(function (item, index) {
            item.querySelector('.template-number').innerText = index + 1;
        });
    }
</script>
@endsection