<h1>Edit Product List Banner</h1>

<a href="{{ route('admin.product-list-banners.index') }}">
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

<form action="{{ route('admin.product-list-banners.update', $banner->banner_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Title</label><br>
        <input 
            type="text" 
            name="title" 
            value="{{ old('title', $banner->title) }}"
        >
    </div>

    <br>

    <div>
        <label>Subtitle</label><br>
        <input 
            type="text" 
            name="subtitle" 
            value="{{ old('subtitle', $banner->subtitle) }}"
        >
    </div>

    <br>

    <div>
        <label>Current Banner Image</label><br>

        @if($banner->image_path)
            <img 
                src="{{ asset('storage/' . $banner->image_path) }}" 
                width="250"
                style="display:block; margin-bottom:10px;"
            >
        @else
            <span>No image</span>
        @endif
    </div>

    <br>

    <div>
        <label>Change Banner Image</label><br>
        <input type="file" name="image_path" accept="image/*">
    </div>

    <br>

    <div>
        <label>Button Text</label><br>
        <input 
            type="text" 
            name="button_text" 
            value="{{ old('button_text', $banner->button_text) }}"
        >
    </div>

    <br>

    <div>
        <label>Link URL</label><br>
        <input 
            type="text" 
            name="link_url" 
            value="{{ old('link_url', $banner->link_url) }}"
        >
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input 
            type="number" 
            name="sort_order" 
            value="{{ old('sort_order', $banner->sort_order) }}"
        >
    </div>

    <br>

    <div>
        <label>
            <input 
                type="checkbox" 
                name="is_active" 
                value="1"
                {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
            >
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>