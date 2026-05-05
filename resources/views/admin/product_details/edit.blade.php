<h1>Edit Product Detail</h1>

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

<form action="{{ route('admin.product-details.update', $detail->product_detail_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Product</label><br>
        <select name="product_id">
            <option value="">-- Select Product --</option>

            @foreach($products as $product)
                <option 
                    value="{{ $product->product_id }}"
                    {{ old('product_id', $detail->product_id) == $product->product_id ? 'selected' : '' }}
                >
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Current Sample Image</label><br>

        @if($detail->sample_image)
            <img 
                src="{{ asset('storage/' . $detail->sample_image) }}" 
                width="150"
            >
        @else
            <span>No image</span>
        @endif
    </div>

    <br>

    <div>
        <label>Change Sample Image</label><br>
        <input type="file" name="sample_image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Detail Content</label><br>
        <div id="detail-content-wrapper">
       @php
    $oldDetails = old('detail_content', $detail->detail_content ?? [
        [
            'headline' => '',
            'desc' => '',
            'emoticon' => '',
        ]
    ]);

    if (empty($oldDetails)) {
        $oldDetails = [
            [
                'headline' => '',
                'desc' => '',
                'emoticon' => '',
            ]
        ];
    }
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
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $detail->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#detail_content'))
        .catch(error => {
            console.error(error);
        });
</script>