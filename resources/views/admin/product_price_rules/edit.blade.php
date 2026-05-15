@extends('admin.layouts.app')

@section('title', 'Edit Product Price Rule | Indigo Admin')

@section('css')
    <style>
        .option-select-box {
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--bg);
            padding: 16px;
            max-height: 360px;
            overflow: auto;
        }

        .option-group-block {
            margin-bottom: 18px;
        }

        .option-group-title {
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--fg-dark);
            font-size: 14px;
        }

        .option-check-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .option-check-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
            color: var(--fg);
        }

        .tier-item {
            max-width: 760px;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            background: #fff;
            margin-bottom: 16px;
        }

        .tier-item .form-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .tier-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        .tier-header h3 {
            margin: 0;
        }

        .tier-item .form-group {
            margin-bottom: 0;
        }

        .tier-item input[type="number"] {
            height: 38px;
        }

        @media (max-width: 800px) {
            .tier-item {
                max-width: 100%;
            }

            .tier-item .form-grid {
                grid-template-columns: 1fr;
            }
        }

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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full {
            grid-column: 1 / -1;
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
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            font-family: inherit;
            background: #fff;
            color: var(--fg);
        }

        .form-group small {
            display: block;
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        .section-title {
            margin: 28px 0 16px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 18px;
            font-weight: 700;
            color: var(--fg-dark);
        }

        .muted-text {
            color: var(--muted);
            font-size: 14px;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .checkbox-grid label {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            color: var(--fg);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .btn-outline,
        .btn-primary {
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
            line-height: 1;
        }

        .btn-outline {
            background: #fff;
            border: 1px solid var(--border);
            color: var(--fg);
        }

        .btn-outline:hover {
            background: var(--bg);
        }

        .btn-primary {
            background: var(--accent);
            border: 1px solid var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
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

        .btn-danger-light {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-danger-light:hover {
            background: #fee2e2;
        }

        .price-tier-card {
            border: 1px solid #d9e0ea;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            max-width: 680px;
        }

        .price-tier-header {
            display: grid;
            grid-template-columns: 1fr 1fr 70px;
            background: #f8fafc;
            border-bottom: 1px solid #d9e0ea;
        }

        .price-tier-title {
            padding: 14px 16px;
            font-size: 15px;
            font-weight: 700;
            color: #23324a;
        }

        .price-tier-row {
            display: grid;
            grid-template-columns: 1fr 1fr 70px;
            gap: 16px;
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            align-items: center;
        }

        .price-tier-row:last-child {
            border-bottom: 0;
        }

        .tier-input-group {
            display: flex;
            align-items: stretch;
            width: 100%;
        }

        .tier-input {
            flex: 1;
            height: 38px;
            border: 1px solid #cfd7e3;
            padding: 0 14px;
            font-size: 15px;
            color: #22314a;
            outline: none;
            background: #fff;
        }

        .tier-input-group .tier-input:first-child {
            border-radius: 6px 0 0 6px;
        }

        .tier-input-group .tier-input:last-child {
            border-radius: 0 6px 6px 0;
        }

        .tier-prefix,
        .tier-suffix {
            min-width: 58px;
            height: 38px;
            padding: 0 12px;
            border: 1px solid #cfd7e3;
            background: #f8fafc;
            color: #23324a;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tier-prefix {
            border-right: 0;
            border-radius: 6px 0 0 6px;
        }

        .tier-suffix {
            border-left: 0;
            border-radius: 0 6px 6px 0;
        }

        .tier-action {
            display: flex;
            justify-content: center;
        }

        .remove-tier {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #b91c1c;
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .remove-tier:hover {
            background: #fee2e2;
        }

        @media (max-width: 700px) {

            .price-tier-header,
            .price-tier-row {
                grid-template-columns: 1fr;
            }

            .price-tier-header .price-tier-title:last-child {
                display: none;
            }

            .tier-action {
                justify-content: flex-start;
            }
        }
        .required-option-simple-box {
    border: 1px solid var(--border);
    border-radius: 8px;
    background: #fff;
    padding: 14px 18px;
    max-height: 420px;
    overflow-y: auto;
}

.required-option-category-link {
    display: inline-block;
    margin-bottom: 8px;
    color: #1d4ed8;
    font-size: 14px;
    text-decoration: underline;
    font-weight: 500;
}

.required-option-list {
    display: flex;
    flex-direction: column;
}

.required-option-group {
    margin-bottom: 18px;
}

.required-option-group:last-child {
    margin-bottom: 0;
}

.required-option-group-title {
    margin: 12px 0 8px;
    padding-bottom: 7px;
    border-bottom: 1px solid #d1d5db;
    color: #111827;
    font-size: 14px;
    font-weight: 700;
}

.required-option-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #1f3b66;
    font-size: 14px;
    line-height: 1.35;
    cursor: pointer;
    margin-bottom: 8px;
}

.required-option-item input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #2563eb;
    flex-shrink: 0;
}
    </style>
@endsection

@section('content')

    <div class="form-card">
        <div class="form-header">
            <div>
                <h1>Edit Product Price Rule</h1>
                <p>Update pricing rule, selected options and quantity tiers.</p>
            </div>

            <a href="{{ route('admin.product-price-rules.index') }}" class="btn-outline">
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.product-price-rules.update', $rule->rule_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-title">Rule Information</div>

            <div class="form-grid">
             <div class="form-group">
    <label>Product</label>

    <input
        type="text"
        value="{{ $rule->product->product_name ?? '-' }}"
        readonly
        style="background:#f3f4f6; cursor:not-allowed;"
    >

    <input
        type="hidden"
        name="product_id"
        id="product_id"
        value="{{ old('product_id', $rule->product_id) }}"
    >
</div>

                <div class="form-group">
                    <label>Rule Name</label>
                    <input type="text" name="rule_name" value="{{ old('rule_name', $rule->rule_name) }}"
                        placeholder="เช่น 20mm + One Side">
                </div>

                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $rule->sort_order) }}">
                </div>
            </div>

            <div class="section-title">Required Options</div>

            @php
                $selectedOptionIds = old('option_ids', $rule->options->pluck('option_id')->toArray());
            @endphp

            <p class="muted-text" style="margin-bottom: 12px;">
                เลือก option ที่ลูกค้าต้องเลือกให้ครบ ถึงจะใช้เรทราคานี้
            </p>

           <div class="required-option-simple-box" id="required-options-box">
    <p class="muted-text">
        Loading options...
    </p>
</div>

          <div class="section-title">Price Tiers</div>

@php
    $oldTiers = old(
        'tiers',
        $rule->tiers->map(function ($tier) {
            return [
                'min_qty' => $tier->min_qty,
                'max_qty' => $tier->max_qty,
                'unit_price' => $tier->unit_price,
            ];
        })->toArray()
    );

    if (empty($oldTiers)) {
        $oldTiers = [
            [
                'min_qty' => '',
                'max_qty' => '',
                'unit_price' => '',
            ],
        ];
    }
@endphp

<div class="price-tier-card">
    <div class="price-tier-header">
        <div class="price-tier-title">Quantity</div>
        <div class="price-tier-title">Unit Price </div>
        <div class="price-tier-title"></div>
    </div>

    <div id="tier-wrapper">
        @foreach ($oldTiers as $index => $tier)
            <div class="price-tier-row">
                <div class="tier-input-group">
                    <input
                        type="number"
                        name="tiers[{{ $index }}][min_qty]"
                        value="{{ $tier['min_qty'] ?? '' }}"
                        class="tier-input"
                        min="1"
                    >

                    <span class="tier-suffix"></span>

                    <input
                        type="hidden"
                        name="tiers[{{ $index }}][max_qty]"
                        value="{{ $tier['max_qty'] ?? '' }}"
                    >
                </div>

                <div class="tier-input-group">
                    <span class="tier-prefix">¥</span>

                    <input
                        type="number"
                        step="0.01"
                        name="tiers[{{ $index }}][unit_price]"
                        value="{{ $tier['unit_price'] ?? '' }}"
                        class="tier-input"
                        min="0"
                    >
                </div>

                <div class="tier-action">
                    <button type="button" class="remove-tier">
                        Remove
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<br>

<button type="button" id="add-tier" class="btn-outline">
    + Add Tier
</button>

            <button type="button" id="add-tier" class="btn-outline">
                + Add Tier
            </button>

            <div class="section-title">Status</div>

            <div class="checkbox-grid">
                <label>
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $rule->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.product-price-rules.index') }}" class="btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Update Price Rule
                </button>
            </div>
        </form>
    </div>

@endsection

@section('js')
<script>
    let tierIndex = document.querySelectorAll('.price-tier-row').length;

    document.getElementById('add-tier').addEventListener('click', function () {
        const wrapper = document.getElementById('tier-wrapper');

        const html = `
            <div class="price-tier-row">
                <div class="tier-input-group">
                    <input
                        type="number"
                        name="tiers[${tierIndex}][min_qty]"
                        class="tier-input"
                        min="1"
                    >

                    <span class="tier-suffix">以上</span>

                    <input
                        type="hidden"
                        name="tiers[${tierIndex}][max_qty]"
                        value=""
                    >
                </div>

                <div class="tier-input-group">
                    <span class="tier-prefix">¥</span>

                    <input
                        type="number"
                        step="0.01"
                        name="tiers[${tierIndex}][unit_price]"
                        class="tier-input"
                        min="0"
                    >
                </div>

                <div class="tier-action">
                    <button type="button" class="remove-tier">
                        Remove
                    </button>
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        tierIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tier')) {
            const items = document.querySelectorAll('.price-tier-row');

            if (items.length <= 1) {
                alert('ต้องมีอย่างน้อย 1 tier');
                return;
            }

            e.target.closest('.price-tier-row').remove();
        }
    });
    /*
|--------------------------------------------------------------------------
| Load Required Options by selected product
|--------------------------------------------------------------------------
*/

const productSelect = document.getElementById('product_id');
const requiredOptionsBox = document.getElementById('required-options-box');

const selectedOptionIds = @json(array_map('strval', $selectedOptionIds));

function renderRequiredOptions(groups) {
    if (!groups || groups.length === 0) {
        requiredOptionsBox.innerHTML = `
            <p class="muted-text">
                No options assigned to this product.
            </p>
        `;
        return;
    }

    let html = `
        

        <div class="required-option-list">
    `;

    groups.forEach(function (group) {
        html += `
            <div class="required-option-group">
                <div class="required-option-group-title">
                    ${group.group_name || '-'}
                </div>
        `;

        group.options.forEach(function (option) {
            const checked = selectedOptionIds.includes(String(option.option_id)) ? 'checked' : '';

            html += `
                <label class="required-option-item">
                    <input
                        type="checkbox"
                        name="option_ids[]"
                        value="${option.option_id}"
                        ${checked}
                    >
                    <span>${option.option_name}</span>
                </label>
            `;
        });

        html += `
            </div>
        `;
    });

    html += `</div>`;

    requiredOptionsBox.innerHTML = html;
}

function loadProductOptions(productId) {
    if (!productId) {
        requiredOptionsBox.innerHTML = `
            <p class="muted-text">
                Please select a product first.
            </p>
        `;
        return;
    }

    requiredOptionsBox.innerHTML = `
        <p class="muted-text">
            Loading options...
        </p>
    `;

    const url = `{{ url('admin-panel/product-price-rules/product-options') }}/${productId}`;

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function (response) {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status);
        }

        return response.json();
    })
    .then(function (data) {
        renderRequiredOptions(data.groups);
    })
    .catch(function (error) {
        console.error(error);

        requiredOptionsBox.innerHTML = `
            <p class="muted-text" style="color:#b91c1c;">
                Cannot load product options.
            </p>
        `;
    });
}

if (productSelect) {
    productSelect.addEventListener('change', function () {
        loadProductOptions(this.value);
    });

    if (productSelect.value) {
        loadProductOptions(productSelect.value);
    }
}

/*
|--------------------------------------------------------------------------
| Select all / unselect all
|--------------------------------------------------------------------------
*/

document.addEventListener('click', function (e) {
    const selectAllLink = e.target.closest('.required-option-category-link');

    if (!selectAllLink) {
        return;
    }

    e.preventDefault();

    const checkboxes = requiredOptionsBox.querySelectorAll('input[name="option_ids[]"]');

    const hasUnchecked = Array.from(checkboxes).some(function (checkbox) {
        return !checkbox.checked;
    });

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = hasUnchecked;
    });
});
</script>
@endsection
