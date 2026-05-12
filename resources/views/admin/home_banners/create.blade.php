<h1>Add Home Banner</h1>

<a href="{{ route('admin.home-banners.index') }}">
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

<form action="{{ route('admin.home-banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title') }}" style="width:400px;">
    </div>

    <br>

    <div>
        <label>Link URL</label><br>
        <input type="text" name="link_url" value="{{ old('link_url') }}" style="width:600px;" placeholder="https://example.com หรือ /products">
    </div>

    <br>

    <div>
        <label>PC Image</label><br>
        <input type="file" name="image_pc" accept="image/*">
        <br>
        <small>แนะนำขนาด PC เช่น 1920x600 หรือ 1440x480</small>
    </div>

    <br>

    <div>
        <label>Mobile Image</label><br>
        <input type="file" name="image_mobile" accept="image/*">
        <br>
        <small>แนะนำขนาด Mobile เช่น 750x900 หรือ 750x1000</small>
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Save</button>
</form>