<h1>Edit Home Banner</h1>

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

<form action="{{ route('admin.home-banners.update', $homeBanner->home_banner_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $homeBanner->title) }}" style="width:400px;">
    </div>

    <br>

    <div>
        <label>Link URL</label><br>
        <input type="text" name="link_url" value="{{ old('link_url', $homeBanner->link_url) }}" style="width:600px;" placeholder="https://example.com หรือ /products">
    </div>

    <br>

    <div>
        <label>Current PC Image</label><br>

        @if($homeBanner->image_pc)
            <img src="{{ asset('storage/' . $homeBanner->image_pc) }}" width="220">
            <br>
            <label style="color:red;">
                <input type="checkbox" name="remove_image_pc" value="1">
                Remove PC image
            </label>
        @else
            No image
        @endif
    </div>

    <br>

    <div>
        <label>Upload New PC Image</label><br>
        <input type="file" name="image_pc" accept="image/*">
    </div>

    <br>

    <div>
        <label>Current Mobile Image</label><br>

        @if($homeBanner->image_mobile)
            <img src="{{ asset('storage/' . $homeBanner->image_mobile) }}" width="120">
            <br>
            <label style="color:red;">
                <input type="checkbox" name="remove_image_mobile" value="1">
                Remove Mobile image
            </label>
        @else
            No image
        @endif
    </div>

    <br>

    <div>
        <label>Upload New Mobile Image</label><br>
        <input type="file" name="image_mobile" accept="image/*">
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', $homeBanner->sort_order) }}" min="0">
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $homeBanner->is_active) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>