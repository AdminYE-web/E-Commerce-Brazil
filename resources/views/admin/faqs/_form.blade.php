<div class="faq-form-card">
    <div class="faq-form-grid">

        <div class="faq-form-group faq-form-full">
            <label>Product</label>
            <select name="product_id">
                <option value="">All / No specific product</option>

                @foreach($products as $product)
                    <option value="{{ $product->product_id }}"
                        {{ old('product_id', $faq->product_id ?? '') == $product->product_id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>

            @error('product_id')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="faq-form-group faq-form-full">
            <label>Question <span>*</span></label>
            <input
                type="text"
                name="question"
                value="{{ old('question', $faq->question ?? '') }}"
                required
            >

            @error('question')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="faq-form-group faq-form-full">
            <label>Answer</label>
            <textarea name="answer" rows="8">{{ old('answer', $faq->answer ?? '') }}</textarea>

            @error('answer')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="faq-form-group">
            <label>Sort Order</label>
            <input
                type="number"
                name="sort_order"
                value="{{ old('sort_order', $faq->sort_order ?? 0) }}"
                min="0"
            >

            @error('sort_order')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="faq-form-group">
            <label>Status <span>*</span></label>
            <select name="status" required>
                <option value="show" {{ old('status', $faq->status ?? 'show') === 'show' ? 'selected' : '' }}>
                    Show
                </option>
                <option value="hide" {{ old('status', $faq->status ?? 'show') === 'hide' ? 'selected' : '' }}>
                    Hide
                </option>
            </select>

            @error('status')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="faq-form-group faq-form-full">
            <label>Display Settings</label>

            <label class="faq-check-box">
                <input type="checkbox" name="show_main" value="1"
                    {{ old('show_main', $faq->show_main ?? 0) ? 'checked' : '' }}>
                Show on Main FAQ page
            </label>

            <label class="faq-check-box">
                <input type="checkbox" name="show_product" value="1"
                    {{ old('show_product', $faq->show_product ?? 0) ? 'checked' : '' }}>
                Show on Product Detail page
            </label>
        </div>

    </div>
</div>