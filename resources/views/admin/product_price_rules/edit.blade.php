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
                <select name="product_id" required>
                    <option value="">-- Select Product --</option>

                    @foreach ($products as $product)
                        <option value="{{ $product->product_id }}"
                            {{ old('product_id', $rule->product_id) == $product->product_id ? 'selected' : '' }}>
                            {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Rule Name</label>
                <input
                    type="text"
                    name="rule_name"
                    value="{{ old('rule_name', $rule->rule_name) }}"
                    placeholder="เช่น 20mm + One Side"
                >
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', $rule->sort_order) }}"
                >
            </div>
        </div>

        <div class="section-title">Required Options</div>

        @php
            $selectedOptionIds = old(
                'option_ids',
                $rule->options->pluck('option_id')->toArray()
            );
        @endphp

        <p class="muted-text" style="margin-bottom: 12px;">
            เลือก option ที่ลูกค้าต้องเลือกให้ครบ ถึงจะใช้เรทราคานี้
        </p>

        <div class="option-select-box">
            @foreach ($options->groupBy('option_group_id') as $groupId => $groupOptions)
                @php
                    $group = $groupOptions->first()->group;
                @endphp

                <div class="option-group-block">
                    <div class="option-group-title">
                        {{ $group->group_name ?? '-' }}
                    </div>

                    <div class="option-check-list">
                        @foreach ($groupOptions as $option)
                            <label class="option-check-item">
                                <input
                                    type="checkbox"
                                    name="option_ids[]"
                                    value="{{ $option->option_id }}"
                                    {{ in_array($option->option_id, $selectedOptionIds) ? 'checked' : '' }}
                                >
                                {{ $option->option_name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section-title">Price Tiers</div>

        <div id="tier-wrapper">
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

            @foreach ($oldTiers as $index => $tier)
                <div class="tier-item">
                    <div class="tier-header">
    <h3>Tier <span class="tier-number">{{ $index + 1 }}</span></h3>

    <button type="button" class="btn-danger-light remove-tier">
        Remove
    </button>
</div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Min Qty</label>
                            <input
                                type="number"
                                name="tiers[{{ $index }}][min_qty]"
                                value="{{ $tier['min_qty'] ?? '' }}"
                            >
                        </div>

                        <div class="form-group">
                            <label>Max Qty</label>
                            <input
                                type="number"
                                name="tiers[{{ $index }}][max_qty]"
                                value="{{ $tier['max_qty'] ?? '' }}"
                            >
                            <small>ปล่อยว่าง = ตั้งแต่ Min Qty ขึ้นไป</small>
                        </div>

                        <div class="form-group">
                            <label>Unit Price</label>
                            <input
                                type="number"
                                step="0.01"
                                name="tiers[{{ $index }}][unit_price]"
                                value="{{ $tier['unit_price'] ?? '' }}"
                            >
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-tier" class="btn-outline">
            + Add Tier
        </button>

        <div class="section-title">Status</div>

        <div class="checkbox-grid">
            <label>
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $rule->is_active) ? 'checked' : '' }}
                >
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
    let tierIndex = document.querySelectorAll('.tier-item').length;

    document.getElementById('add-tier').addEventListener('click', function () {
        const wrapper = document.getElementById('tier-wrapper');

        const html = `
            <div class="tier-item">
                <div class="tier-header">
                    <h3>Tier <span class="tier-number">${tierIndex + 1}</span></h3>

                    <button type="button" class="btn-danger-light remove-tier">
                        Remove
                    </button>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Min Qty</label>
                        <input type="number" name="tiers[${tierIndex}][min_qty]">
                    </div>

                    <div class="form-group">
                        <label>Max Qty</label>
                        <input type="number" name="tiers[${tierIndex}][max_qty]">
                        <small>ปล่อยว่าง = ตั้งแต่ Min Qty ขึ้นไป</small>
                    </div>

                    <div class="form-group">
                        <label>Unit Price</label>
                        <input type="number" step="0.01" name="tiers[${tierIndex}][unit_price]">
                    </div>
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        tierIndex++;
        updateTierNumbers();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tier')) {
            const items = document.querySelectorAll('.tier-item');

            if (items.length <= 1) {
                alert('ต้องมีอย่างน้อย 1 tier');
                return;
            }

            e.target.closest('.tier-item').remove();
            updateTierNumbers();
        }
    });

    function updateTierNumbers() {
        document.querySelectorAll('.tier-item').forEach(function (item, index) {
            item.querySelector('.tier-number').innerText = index + 1;
        });
    }
</script>
@endsection