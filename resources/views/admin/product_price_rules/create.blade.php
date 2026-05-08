<h1>Add Product Price Rule</h1>

<a href="{{ route('admin.product-price-rules.index') }}">
    Back
</a>

<br><br>

@if($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.product-price-rules.store') }}" method="POST">
    @csrf

    <div>
        <label>Product</label><br>
        <select name="product_id" required>
            <option value="">-- Select Product --</option>

            @foreach($products as $product)
                <option 
                    value="{{ $product->product_id }}"
                    {{ old('product_id') == $product->product_id ? 'selected' : '' }}
                >
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Rule Name</label><br>
        <input 
            type="text" 
            name="rule_name" 
            value="{{ old('rule_name') }}"
            placeholder="เช่น 20mm + One Side"
        >
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
    </div>

    <br>

    <h3>Required Options</h3>
    <p>เลือก option ที่ลูกค้าต้องเลือกให้ครบ ถึงจะใช้เรทราคานี้</p>

    <div style="border:1px solid #ddd; padding:15px; max-height:350px; overflow:auto;">
        @foreach($options->groupBy('option_group_id') as $groupId => $groupOptions)
            @php
                $group = $groupOptions->first()->group;
            @endphp

            <div style="margin-bottom:15px;">
                <strong>{{ $group->group_name ?? '-' }}</strong>

                <div style="margin-left:15px; margin-top:6px;">
                    @foreach($groupOptions as $option)
                        <label style="display:block; margin-bottom:4px;">
                            <input 
                                type="checkbox" 
                                name="option_ids[]" 
                                value="{{ $option->option_id }}"
                                {{ in_array($option->option_id, old('option_ids', [])) ? 'checked' : '' }}
                            >
                            {{ $option->option_name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <br>

    <h3>Price Tiers</h3>

    <div id="tier-wrapper">
        @php
            $oldTiers = old('tiers', [
                [
                    'min_qty' => '',
                    'max_qty' => '',
                    'unit_price' => '',
                ]
            ]);
        @endphp

        @foreach($oldTiers as $index => $tier)
            <div class="tier-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Tier <span class="tier-number">{{ $index + 1 }}</span></h4>

                <div>
                    <label>Min Qty</label><br>
                    <input 
                        type="number" 
                        name="tiers[{{ $index }}][min_qty]" 
                        value="{{ $tier['min_qty'] ?? '' }}"
                    >
                </div>

                <br>

                <div>
                    <label>Max Qty</label><br>
                    <input 
                        type="number" 
                        name="tiers[{{ $index }}][max_qty]" 
                        value="{{ $tier['max_qty'] ?? '' }}"
                    >
                    <small>ปล่อยว่าง = ตั้งแต่ Min Qty ขึ้นไป</small>
                </div>

                <br>

                <div>
                    <label>Unit Price</label><br>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="tiers[{{ $index }}][unit_price]" 
                        value="{{ $tier['unit_price'] ?? '' }}"
                    >
                </div>

                <br>

                <button type="button" class="remove-tier">
                    Remove
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" id="add-tier">
        + Add Tier
    </button>

    <br><br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" checked>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>

<script>
    let tierIndex = document.querySelectorAll('.tier-item').length;

    document.getElementById('add-tier').addEventListener('click', function () {
        const wrapper = document.getElementById('tier-wrapper');

        const html = `
            <div class="tier-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Tier <span class="tier-number">${tierIndex + 1}</span></h4>

                <div>
                    <label>Min Qty</label><br>
                    <input type="number" name="tiers[${tierIndex}][min_qty]">
                </div>

                <br>

                <div>
                    <label>Max Qty</label><br>
                    <input type="number" name="tiers[${tierIndex}][max_qty]">
                    <small>ปล่อยว่าง = ตั้งแต่ Min Qty ขึ้นไป</small>
                </div>

                <br>

                <div>
                    <label>Unit Price</label><br>
                    <input type="number" step="0.01" name="tiers[${tierIndex}][unit_price]">
                </div>

                <br>

                <button type="button" class="remove-tier">
                    Remove
                </button>
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