<h1>Add Product Detail</h1>

<a href="{{ route('admin.product-details.index') }}">
    Back
</a>

<br><br>

@if ($errors->any())
    <div style="color:red; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.product-details.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Product</label><br>
        <select name="product_id">
            <option value="">-- Select Product --</option>

            @foreach ($products as $product)
                <option value="{{ $product->product_id }}"
                    {{ old('product_id', request('product_id')) == $product->product_id ? 'selected' : '' }}>
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    {{-- <div>
        <label>Sample Image</label><br>
        <input type="file" name="sample_image" accept="image/*">
    </div>

    <br> --}}
    <div>
        <label>Specification Image</label><br>
        <input type="file" name="specification_image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Detail Content</label><br>

        <div id="detail-content-wrapper">
            @php
                $oldDetails = old('detail_content', [
                    [
                        'headline' => '',
                        'desc' => '',
                        'emoticon' => '',
                    ],
                ]);
            @endphp

            @foreach ($oldDetails as $index => $item)
                <div class="detail-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Detail Set <span class="detail-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Headline</label><br>
                        <input type="text" name="detail_content[{{ $index }}][headline]"
                            value="{{ $item['headline'] ?? '' }}" style="width:100%;">
                    </div>

                    <br>

                    <div>
                        <label>Description</label><br>
                        <textarea name="detail_content[{{ $index }}][desc]" rows="4" style="width:100%;">{{ $item['desc'] ?? '' }}</textarea>
                    </div>

                    <br>

                    <div>
                        <label>Icon Image</label><br>
                        <input type="file" name="detail_icon_images[{{ $index }}]" accept="image/*">
                    </div>

                    <br>


                    <button type="button" class="remove-detail-item">
                        Remove
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-detail-item">
            + Add Detail Set
        </button>
    </div>

    <br>
    <div>
        <label>Specification Content</label><br>

        <div id="spec-content-wrapper">
            @php
                $oldSpecs = old('specification_content', [
                    [
                        'title' => '',
                        'desc' => '',
                        'icon_image' => '',
                    ],
                ]);
            @endphp

            @foreach ($oldSpecs as $index => $item)
                <div class="spec-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Spec Set <span class="spec-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Title</label><br>
                        <input type="text" name="specification_content[{{ $index }}][title]"
                            value="{{ $item['title'] ?? '' }}" style="width:100%;" placeholder="เช่น Width Options:">
                    </div>

                    <br>

                    <div>
                        <label>Description</label><br>
                        <textarea name="specification_content[{{ $index }}][desc]" rows="3" style="width:100%;"
                            placeholder="เช่น 10mm, 15mm, 20mm, and more">{{ $item['desc'] ?? '' }}</textarea>
                    </div>

                    <br>

                    <div>
                        <label>Icon Image</label><br>
                        <input type="file" name="spec_icon_images[{{ $index }}]" accept="image/*">
                    </div>

                    <br>

                    <button type="button" class="remove-spec-item">
                        Remove
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-spec-item">
            + Add Spec Set
        </button>
    </div>
    <br>

    <div>
        <label>Accordion Content</label><br>

        <div id="accordion-content-wrapper">
            @php
                $oldAccordions = old('accordion_content', [
                    [
                        'title' => '',
                        'content' => '',
                    ],
                ]);
            @endphp

            @foreach ($oldAccordions as $index => $item)
                <div class="accordion-item-admin" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Accordion Set <span class="accordion-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Title</label><br>
                        <input type="text" name="accordion_content[{{ $index }}][title]"
                            value="{{ $item['title'] ?? '' }}" style="width:100%;" placeholder="เช่น Production fee">
                    </div>

                    <br>

                    <div>
                        <label>Content</label><br>
                        <textarea name="accordion_content[{{ $index }}][content]" class="accordion-ckeditor" rows="8"
                            style="width:100%;">{{ $item['content'] ?? '' }}</textarea>
                    </div>

                    <br>

                    <button type="button" class="remove-accordion-item">
                        Remove Accordion
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-accordion-item">
            + Add Accordion Set
        </button>
    </div>

    <br>

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
    let detailIndex = document.querySelectorAll('.detail-item').length;

    document.getElementById('add-detail-item').addEventListener('click', function() {
        const wrapper = document.getElementById('detail-content-wrapper');

        const html = `
            <div class="detail-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Detail Set <span class="detail-number">${detailIndex + 1}</span></h4>

                <div>
                    <label>Headline</label><br>
                    <input 
                        type="text" 
                        name="detail_content[${detailIndex}][headline]" 
                        value=""
                        style="width:100%;"
                    >
                </div>

                <br>

                <div>
                    <label>Description</label><br>
                    <textarea 
                        name="detail_content[${detailIndex}][desc]" 
                        rows="4"
                        style="width:100%;"
                    ></textarea>
                </div>

                <br>

              <div>
    <label>Icon Image</label><br>
    <input 
        type="file" 
        name="detail_icon_images[${detailIndex}]" 
        accept="image/*"
    >
</div>

                <br>

                <button type="button" class="remove-detail-item">
                    Remove
                </button>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        detailIndex++;
        updateDetailNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail-item')) {
            const items = document.querySelectorAll('.detail-item');

            if (items.length <= 1) {
                alert('ต้องมี Detail อย่างน้อย 1 ชุด');
                return;
            }

            e.target.closest('.detail-item').remove();
            updateDetailNumbers();
        }
    });

    function updateDetailNumbers() {
        document.querySelectorAll('.detail-item').forEach(function(item, index) {
            item.querySelector('.detail-number').innerText = index + 1;
        });
    }
</script>
<script>
    let specIndex = document.querySelectorAll('.spec-item').length;

    document.getElementById('add-spec-item').addEventListener('click', function() {
        const wrapper = document.getElementById('spec-content-wrapper');

        const html = `
            <div class="spec-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Spec Set <span class="spec-number">${specIndex + 1}</span></h4>

                <div>
                    <label>Title</label><br>
                    <input 
                        type="text" 
                        name="specification_content[${specIndex}][title]" 
                        value=""
                        style="width:100%;"
                    >
                </div>

                <br>

                <div>
                    <label>Description</label><br>
                    <textarea 
                        name="specification_content[${specIndex}][desc]" 
                        rows="3"
                        style="width:100%;"
                    ></textarea>
                </div>

                <br>

                <div>
                    <label>Icon Image</label><br>
                    <input 
                        type="file" 
                        name="spec_icon_images[${specIndex}]" 
                        accept="image/*"
                    >
                </div>

                <br>

                <button type="button" class="remove-spec-item">
                    Remove
                </button>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        specIndex++;
        updateSpecNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-spec-item')) {
            const items = document.querySelectorAll('.spec-item');

            if (items.length <= 1) {
                alert('ต้องมี Spec อย่างน้อย 1 ชุด');
                return;
            }

            e.target.closest('.spec-item').remove();
            updateSpecNumbers();
        }
    });

    function updateSpecNumbers() {
        document.querySelectorAll('.spec-item').forEach(function(item, index) {
            item.querySelector('.spec-number').innerText = index + 1;
        });
    }
</script>
