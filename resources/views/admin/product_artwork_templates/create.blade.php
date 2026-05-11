<h1>Add Product Artwork Templates</h1>

<a href="{{ route('admin.product-artwork-templates.index') }}">
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

<form 
    action="{{ route('admin.product-artwork-templates.store') }}" 
    method="POST"
    enctype="multipart/form-data"
>
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

    <h3>Templates</h3>

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
            <div class="template-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>
                    Template <span class="template-number">{{ $index + 1 }}</span>
                </h4>

                <div>
                    <label>Template Name</label><br>
                    <input 
                        type="text" 
                        name="templates[{{ $index }}][template_name]" 
                        value="{{ $template['template_name'] ?? '' }}"
                        style="width:100%;"
                        placeholder="เช่น No artwork template"
                        required
                    >
                </div>

                <br>

                <div>
                    <label>Template Image</label><br>
                    <input 
                        type="file" 
                        name="templates[{{ $index }}][image_path]" 
                        accept="image/*"
                    >
                </div>

                <br>

                <div>
                    <label>Sort Order</label><br>
                    <input 
                        type="number" 
                        name="templates[{{ $index }}][sort_order]" 
                        value="{{ $template['sort_order'] ?? 0 }}"
                        min="0"
                    >
                </div>

                <br>

                <div>
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

                <br>

                <button type="button" class="remove-template">
                    Remove
                </button>
            </div>
        @endforeach
    </div>

    <button type="button" id="add-template">
        + Add Template
    </button>

    <br><br>

    <button type="submit">Save All Templates</button>
</form>

<script>
    let templateIndex = document.querySelectorAll('.template-item').length;

    document.getElementById('add-template').addEventListener('click', function () {
        const wrapper = document.getElementById('template-wrapper');

        const html = `
            <div class="template-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>
                    Template <span class="template-number">${templateIndex + 1}</span>
                </h4>

                <div>
                    <label>Template Name</label><br>
                    <input 
                        type="text" 
                        name="templates[${templateIndex}][template_name]" 
                        style="width:100%;"
                        placeholder="เช่น No artwork template"
                        required
                    >
                </div>

                <br>

                <div>
                    <label>Template Image</label><br>
                    <input 
                        type="file" 
                        name="templates[${templateIndex}][image_path]" 
                        accept="image/*"
                    >
                </div>

                <br>

                <div>
                    <label>Sort Order</label><br>
                    <input 
                        type="number" 
                        name="templates[${templateIndex}][sort_order]" 
                        value="0"
                        min="0"
                    >
                </div>

                <br>

                <div>
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

                <br>

                <button type="button" class="remove-template">
                    Remove
                </button>
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