<h1>Add Product List Banner</h1>

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

<form action="{{ route('admin.product-list-banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}">
    </div>

    <br>

    <div>
        <label>Subtitle</label><br>
        <input type="text" name="subtitle" value="{{ old('subtitle') }}">
    </div>

    <br>

    <div>
        <label>Banner Image</label><br>
        <input type="file" name="image_path" accept="image/*">
        <br>
        <small>แนะนำขนาดประมาณ 1440x360 หรือ 1920x480</small>
    </div>

    <br>

    <div>
        <label>Button Text</label><br>
        <input type="text" name="button_text" value="{{ old('button_text') }}" placeholder="เช่น Ver Detalhes">
    </div>

    <br>

    <div>
        <label>Link URL</label><br>
        <input type="text" name="link_url" value="{{ old('link_url') }}" placeholder="/products">
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
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