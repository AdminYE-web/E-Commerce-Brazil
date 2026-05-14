@extends('admin.layouts.app')

@section('title', 'Edit Gallery Banner | Indigo Admin')

@section('css')
<style>
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .form-header h1 {
        margin: 0 0 6px;
        font-size: 24px;
        color: var(--fg-dark);
    }

    .form-header p,
    .muted-text {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label,
    .image-panel > label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--fg-dark);
    }

    .form-group input {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 14px;
        font-family: inherit;
        background: #fff;
        color: var(--fg);
    }

    .image-panel {
        margin-bottom: 18px;
    }

    .image-grid {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .image-box {
        width: 180px;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px;
        background: var(--bg);
    }

    .image-box img {
        width: 100%;
        height: 90px;
        object-fit: cover;
        display: block;
        border-radius: 8px;
        background: #fff;
    }

    .checkbox-box {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 12px;
        display: inline-flex;
        gap: 8px;
        align-items: center;
    }

    .alert-error,
    .alert-success {
        margin-bottom: 18px;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
    }

    .btn-primary {
        background: var(--accent);
        border: 1px solid var(--accent);
        color: #fff;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    @media (max-width: 900px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="form-card">
    <div class="form-header">
        <div>
            <h1>Edit Gallery Banner</h1>
            <p>Update gallery banner PC image, mobile image and link.</p>
        </div>

        <a href="{{ route('admin.gallery-banners.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery-banners.update', $galleryBanner->gallery_banner_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group full">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $galleryBanner->title) }}">
            </div>

            <div class="form-group full">
                <label>Link URL</label>
                <input type="text" name="link_url" value="{{ old('link_url', $galleryBanner->link_url) }}">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $galleryBanner->sort_order) }}">
            </div>

            <div class="form-group">
                <label class="checkbox-box">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $galleryBanner->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
        </div>

        <div class="image-panel">
            <label>Current PC Image</label>

            @if($galleryBanner->image_pc)
                <div class="image-grid">
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $galleryBanner->image_pc) }}" alt="PC banner">
                    </div>
                </div>
            @else
                <p class="muted-text">No PC image</p>
            @endif
        </div>

        <div class="form-group">
            <label>Change PC Image</label>
            <input type="file" name="image_pc" accept="image/*">
        </div>

        <div class="image-panel">
            <label>Current Mobile Image</label>

            @if($galleryBanner->image_mobile)
                <div class="image-grid">
                    <div class="image-box">
                        <img src="{{ asset('storage/' . $galleryBanner->image_mobile) }}" alt="Mobile banner">
                    </div>
                </div>
            @else
                <p class="muted-text">No Mobile image</p>
            @endif
        </div>

        <div class="form-group">
            <label>Change Mobile Image</label>
            <input type="file" name="image_mobile" accept="image/*">
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.gallery-banners.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">Update Banner</button>
        </div>
    </form>
</div>

@endsection