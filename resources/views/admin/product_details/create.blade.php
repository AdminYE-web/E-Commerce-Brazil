<h1>Add Product Detail</h1>

<a href="{{ route('admin.product-details.index') }}">
    Back
</a>

<br><br>

@if($errors->any())
    <div style="color:red; margin-bottom: 15px;">
        <ul>
            @foreach($errors->all() as $error)
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

            @foreach($products as $product)
                <option 
    value="{{ $product->product_id }}"
    {{ old('product_id', request('product_id')) == $product->product_id ? 'selected' : '' }}
>
    {{ $product->product_name }}
</option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Sample Image</label><br>
        <input type="file" name="sample_image" accept="image/*">
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
                ]
            ]);
        @endphp

        @foreach($oldDetails as $index => $item)
            <div class="detail-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Detail Set <span class="detail-number">{{ $index + 1 }}</span></h4>

                <div>
                    <label>Headline</label><br>
                    <input 
                        type="text" 
                        name="detail_content[{{ $index }}][headline]" 
                        value="{{ $item['headline'] ?? '' }}"
                        style="width:100%;"
                    >
                </div>

                <br>

                <div>
                    <label>Description</label><br>
                    <textarea 
                        name="detail_content[{{ $index }}][desc]" 
                        rows="4"
                        style="width:100%;"
                    >{{ $item['desc'] ?? '' }}</textarea>
                </div>

                <br>

                <div>
                    <label>Emoticon</label><br>
                    <input 
                        type="text" 
                        name="detail_content[{{ $index }}][emoticon]" 
                        value="{{ $item['emoticon'] ?? '' }}"
                        placeholder="เช่น 😊 🔥 ⭐"
                        style="width:100%;"
                    >
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

    document.getElementById('add-detail-item').addEventListener('click', function () {
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
                    <label>Emoticon</label><br>
                    <input 
                        type="text" 
                        name="detail_content[${detailIndex}][emoticon]" 
                        value=""
                        placeholder="เช่น 😊 🔥 ⭐"
                        style="width:100%;"
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

    document.addEventListener('click', function (e) {
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
        document.querySelectorAll('.detail-item').forEach(function (item, index) {
            item.querySelector('.detail-number').innerText = index + 1;
        });
    }
</script>