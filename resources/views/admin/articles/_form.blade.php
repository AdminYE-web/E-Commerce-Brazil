<div class="article-form-card">
    <div class="article-form-grid">
        <div class="article-form-group">
            <label>Title <span>*</span></label>
            <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" required>
            @error('title') <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="article-form-group">
    <label>Translation Key</label>
    <input
        type="text"
        name="translation_key"
        value="{{ old('translation_key', $article->translation_key ?? '') }}"
        placeholder="เช่น acrylic_cut_path_001"
    >
    <small>ใช้ key เดียวกันสำหรับบทความเดียวกันในหลายภาษา</small>

    @error('translation_key')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>

        <div class="article-form-group">
            <label>Category</label>
            <input type="text" name="category" value="{{ old('category', $article->category ?? '') }}">
            @error('category') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="article-form-group">
            <label>Article Date</label>
            <input
                type="date"
                name="article_date"
                value="{{ old('article_date', isset($article) && $article->article_date ? \Carbon\Carbon::parse($article->article_date)->format('Y-m-d') : '') }}"
            >
            @error('article_date') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="article-form-group">
            <label>Cover Image</label>
            <input type="file" name="cover_image" accept="image/*">

            @if(!empty($article->cover_image))
                <div class="article-cover-preview">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="">
                </div>
            @endif

            @error('cover_image') <div class="error-text">{{ $message }}</div> @enderror
        </div>
        <div class="article-form-group article-form-group-full">
    <label>Description</label>
    <textarea
        name="description"
        rows="4"
        placeholder="Short description shown under cover image..."
    >{{ old('description', $article->description ?? '') }}</textarea>

    @error('description')
        <div class="error-text">{{ $message }}</div>
    @enderror
</div>
    </div>

    <div class="article-form-group">
        <label>Detail</label>
        <div class="article-editor-wrap">
            <textarea name="detail" id="article_detail">{{ old('detail', $article->detail ?? '') }}</textarea>
        </div>
        @error('detail') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <label class="article-active-box">
        <input type="checkbox" name="is_active" value="1"
            {{ old('is_active', $article->is_active ?? 1) ? 'checked' : '' }}>
        Active
    </label>
</div>