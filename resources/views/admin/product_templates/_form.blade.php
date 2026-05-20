<div class="template-form-card">
    <div class="template-form-grid">

        <div class="template-form-group">
            <label>Product <span>*</span></label>
            <select name="product_id" required>
                <option value="">-- Select Product --</option>

                @foreach($products as $product)
                    <option value="{{ $product->product_id }}"
                        {{ old('product_id', $template->product_id ?? '') == $product->product_id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>

            @error('product_id')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

      <div class="template-form-group">
    <label>Template Size</label>
    <input
        type="text"
        name="template_size"
        value="{{ old('template_size', $template->template_size ?? '') }}"
        placeholder="Optional: Ex: 10mm, 15mm, A4, 70x70mm"
    >

    <small style="display:block;margin-top:6px;color:var(--muted);font-size:12px;">
        Leave blank if this product does not have size variations.
    </small>

    @error('template_size')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

        <div class="template-form-group template-form-full">
            <label>Template File {{ empty($template) ? '*' : '' }}</label>

            <div class="template-upload-box">
               <input
    type="file"
    name="template_file"
    id="template_file"
    class="template-upload-input"
    accept=".pdf,.ai,application/pdf,application/postscript,application/octet-stream"
    {{ empty($template) ? 'required' : '' }}
>

                <label for="template_file" class="template-upload-btn">
                    Upload PDF / AI File
                </label>

                <div class="template-upload-file-name" id="templateFileName">
                    @if(!empty($template->original_name))
                        Current file: {{ $template->original_name }}
                    @else
                        No file selected
                    @endif
                </div>

                @if(!empty($template->file_path))
                    <div style="margin-top:10px;">
                        <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank" class="template-current-file">
                            View current file
                        </a>
                    </div>
                @endif
            </div>

            @error('template_file')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="template-form-group">
            <label class="template-active-box">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $template->is_active ?? 1) ? 'checked' : '' }}>
                Active
            </label>
        </div>

    </div>
</div>