@extends('admin.layouts.app')

@section('title', 'Create Quotation | Indigo Admin')


@section('css')
    <style>
        .quotation-page-card {
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px;
        }

        .quotation-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 20px;
        }

        .quotation-form-group {
            margin-bottom: 16px;
        }

        .quotation-form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 700;
            color: var(--fg-dark);
        }

        .quotation-form-group input,
        .quotation-form-group select,
        .quotation-form-group textarea {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            color: var(--fg-dark);
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }

        .quotation-form-group textarea {
            resize: vertical;
            line-height: 1.5;
        }

        .quotation-form-full {
            grid-column: 1 / -1;
        }

        .quotation-section-title {
            margin: 26px 0 16px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 20px;
            font-weight: 800;
            color: var(--fg-dark);
        }

        .quotation-item-box {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 18px;
            background: #fff;
        }

        .quotation-options-area {
            margin-top: 16px;
        }

        .quotation-option-group {
            padding: 16px;
            margin-bottom: 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #f8fafc;
        }

        .quotation-option-group-title {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 800;
            color: #0b2d68;
        }

        .quotation-option-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 8px 0;
            font-size: 14px;
            color: #111;
        }

        .quotation-option-label input {
            width: 15px;
            height: 15px;
            accent-color: var(--accent);
        }

        .quotation-item-summary {
            margin-top: 14px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #eef4ff;
            color: #0b2d68;
            font-size: 16px;
            font-weight: 800;
        }

        .quotation-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .quotation-save-btn {
            min-width: 160px;
            height: 42px;
            border: 1px solid var(--accent);
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            padding: 0 22px;
        }

        .quotation-remove-btn {
            margin-top: 10px;
            min-width: 100px;
            height: 36px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            background: #fff;
            color: #dc2626;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .quotation-form-grid {
                grid-template-columns: 1fr;
            }

            .quotation-form-full {
                grid-column: auto;
            }

            .quotation-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
        .quotation-grand-summary{
            text-align: end;
        }
    </style>
@endsection
@section('content')

    <form action="{{ route('admin.quotations.store') }}" method="POST" id="quotation-form">
        @csrf

        <div class="table-card quotation-page-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Create Quotation</div>
                    <div class="showing-text">Create quotation for customer.</div>
                </div>

                <a href="{{ route('admin.quotations.index') }}" class="btn-outline">
                    Back
                </a>
            </div>

            <div class="quotation-form-grid">
                <div class="quotation-form-group quotation-form-full">
                    <label>Quotation No.</label>
                    <input type="text" name="quotation_no" value="{{ old('quotation_no', $quotationNo) }}" readonly>
                </div>

                <div class="quotation-form-group quotation-form-full">
                    <label>Quotation Date</label>
                    <input type="date" name="quotation_date" value="{{ old('quotation_date', now()->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="quotation-form-group quotation-form-full">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                </div>

                <div class="quotation-form-group quotation-form-full">
                    <label>Customer Email</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}">
                </div>

                <div class="quotation-form-group quotation-form-full">
                    <label>Customer Address</label>
                    <textarea name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
                </div>

                <div class="quotation-form-group quotation-form-full">
                    <label>Note</label>
                    <textarea name="note" rows="3">{{ old('note') }}</textarea>
                </div>
            </div>

            <hr>

            <h3 class="quotation-section-title">Products</h3>

            <div id="quotation-items"></div>

            <button type="button" class="btn-outline" id="add-item-btn">
                + Add Product
            </button>

            <div class="quotation-actions">
                <button type="submit" class="quotation-save-btn">
                    Save Quotation
                </button>
            </div>
            <div class="quotation-grand-summary">
                <div>Subtotal: ¥<span id="quotationSubtotal">0.00</span></div>
                <div>Shipping: <span id="quotationShipping">¥800.00</span></div>
                <div>VAT 10%: ¥<span id="quotationVat">0.00</span></div>
                <div><strong>Grand Total: ¥<span id="quotationGrandTotal">0.00</span></strong></div>
            </div>
        </div>

    </form>

    <template id="quotation-item-template">
        <div class="quotation-item-box" data-item-index="__INDEX__">
            <div class="quotation-form-grid">
                <div class="quotation-form-group">
                    <label>Product</label>
                    <select name="items[__INDEX__][product_id]" class="quotation-product-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->product_id }}">
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="quotation-form-group">
                    <label>Quantity</label>
                    <input type="number" name="items[__INDEX__][quantity]" class="quotation-qty" value="1"
                        min="1" required>
                </div>
            </div>

            <div class="quotation-options-area"></div>

            <div class="quotation-item-summary">
                Item Total: ¥<span class="quotation-item-total">0.00</span>
            </div>

            <button type="button" class="quotation-remove-btn remove-item-btn">
                Remove
            </button>
        </div>
    </template>



@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 0;

            const wrapper = document.getElementById('quotation-items');
            const template = document.getElementById('quotation-item-template').innerHTML;
            const addBtn = document.getElementById('add-item-btn');

            addBtn.addEventListener('click', function() {
                addItem();
            });

            function addItem() {
                const html = template.replaceAll('__INDEX__', itemIndex);
                wrapper.insertAdjacentHTML('beforeend', html);
                itemIndex++;
            }

            wrapper.addEventListener('change', function(e) {
                if (e.target.classList.contains('quotation-product-select')) {
                    loadProductOptions(e.target);
                }

                if (
    e.target.classList.contains('quotation-option-input') ||
    e.target.classList.contains('quotation-qty')
) {
    calculateItemTotal(e.target.closest('.quotation-item-box'));
    calculateQuotationSummary();
}
            });

            wrapper.addEventListener('click', function(e) {
               if (e.target.classList.contains('remove-item-btn')) {
    e.target.closest('.quotation-item-box').remove();
    calculateQuotationSummary();
}
            });

            function loadProductOptions(select) {
                const productId = select.value;
                const itemBox = select.closest('.quotation-item-box');
                const optionsArea = itemBox.querySelector('.quotation-options-area');

                optionsArea.innerHTML = '';

                if (!productId) return;

                fetch(`{{ route('admin.quotations.productOptions', ':productId') }}`.replace(':productId',
                        productId))
                    .then(response => response.json())
                    .then(data => {
                        let html = '';

                        data.groups.forEach(group => {
                            html += `
    <div class="quotation-option-group">
        <div class="quotation-option-group-title">${group.group_name}</div>
`;

                            group.options.forEach(option => {
                                const priceText = Number(option.additional_price) > 0 ?
                                    ` (+¥${Number(option.additional_price).toFixed(2)})` :
                                    '';

                                html += `
                            <label class="quotation-option-label">
                                <input
                                    type="radio"
                                    class="quotation-option-input"
                                    name="items[${itemBox.dataset.itemIndex}][options][${group.group_id}]"
                                    value="${option.option_id}"
                                    data-price="${option.additional_price}"
                                    data-price-type="${option.price_type || 'per_order'}"
                                >
                                ${option.option_name}${priceText}
                            </label>
                        `;
                            });

                            html += `</div>`;
                        });

                        optionsArea.innerHTML = html;

                        itemBox.dataset.priceRules = JSON.stringify(data.price_rules || []);

                        calculateItemTotal(itemBox);
                        calculateQuotationSummary();
                    });
            }

            function calculateItemTotal(itemBox) {
                const qty = parseInt(itemBox.querySelector('.quotation-qty')?.value || 1);
                const checkedOptions = itemBox.querySelectorAll('.quotation-option-input:checked');

                const selectedOptionIds = Array.from(checkedOptions).map(input => parseInt(input.value));
                const priceRules = JSON.parse(itemBox.dataset.priceRules || '[]');

                const matchedRule = findMatchedRule(priceRules, selectedOptionIds);
                const unitPrice = getUnitPrice(matchedRule, qty);

                let optionTotal = 0;

                checkedOptions.forEach(input => {
                    const optionId = parseInt(input.value);
                    const price = parseFloat(input.dataset.price || 0);
                    const priceType = input.dataset.priceType || 'per_order';

                    const isRuleOption = matchedRule && matchedRule.option_ids.map(Number).includes(
                        optionId);

                    if (!isRuleOption) {
                        optionTotal += priceType === 'per_item' ? price * qty : price;
                    }
                });

                const itemTotal = (unitPrice * qty) + optionTotal;

                itemBox.querySelector('.quotation-item-total').textContent = itemTotal.toFixed(2);
            }

            function findMatchedRule(priceRules, selectedOptionIds) {
                const matched = priceRules.filter(rule => {
                    const ruleOptionIds = rule.option_ids || [];

                    if (!ruleOptionIds.length) return false;

                    return ruleOptionIds.every(id => selectedOptionIds.includes(parseInt(id)));
                });

                if (!matched.length) return null;

                matched.sort((a, b) => (b.option_ids || []).length - (a.option_ids || []).length);

                return matched[0];
            }

            function getUnitPrice(rule, qty) {
                if (!rule) return 0;

                const matchedTier = (rule.tiers || []).find(tier => {
                    const min = parseInt(tier.min_qty);
                    const max = tier.max_qty === null ? null : parseInt(tier.max_qty);

                    return qty >= min && (max === null || qty <= max);
                });

                if (matchedTier) {
                    return parseFloat(matchedTier.unit_price);
                }

                const sorted = [...(rule.tiers || [])].sort((a, b) => parseInt(b.min_qty) - parseInt(a.min_qty));

                return sorted.length ? parseFloat(sorted[0].unit_price) : 0;
            }

           addItem();
calculateQuotationSummary();
        });

        function calculateQuotationSummary() {
            let subtotal = 0;

            document.querySelectorAll('.quotation-item-total').forEach(function(el) {
                subtotal += parseFloat(el.textContent || 0);
            });

            const discountInput = document.querySelector('input[name="discount_amount"]');
            const discount = discountInput ? parseFloat(discountInput.value || 0) : 0;

            const afterDiscount = Math.max(subtotal - discount, 0);
            const shipping = afterDiscount >= 11000 ? 0 : 800;
            const vat = (afterDiscount + shipping) * 0.10;
            const grandTotal = afterDiscount + shipping + vat;

            document.getElementById('quotationSubtotal').textContent = subtotal.toFixed(2);
            document.getElementById('quotationShipping').textContent = shipping > 0 ? '¥' + shipping.toFixed(2) : 'Free';
            document.getElementById('quotationVat').textContent = vat.toFixed(2);
            document.getElementById('quotationGrandTotal').textContent = grandTotal.toFixed(2);
        }
    </script>
@endsection
