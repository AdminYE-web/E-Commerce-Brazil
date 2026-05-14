@extends('admin.layouts.app')

@section('title', 'Gallery Banners | Indigo Admin')

@section('css')
<style>
    .alert-success {
        margin: 0 24px 16px;
        padding: 12px 16px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        font-size: 14px;
    }

    .banner-img {
        width: 120px;
        height: 54px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
    }

    .action-link {
        border: none;
        background: none;
        color: var(--accent);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        padding: 0;
        font-family: inherit;
    }

    .action-link.delete {
        color: #dc2626;
    }
</style>
@endsection

@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Gallery Banners</div>
            <div class="showing-text">
                Manage gallery page banners for PC and mobile.
            </div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.gallery-banners.create') }}" class="btn-outline">
                + Add Gallery Banner
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>PC Image</th>
                <th>Mobile Image</th>
                <th>Title</th>
                <th>Link</th>
                <th>Sort</th>
                <th>Status</th>
                <th style="text-align:right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse($banners as $banner)
                <tr>
                    <td>
                        @if($banner->image_pc)
                            <img src="{{ asset('storage/' . $banner->image_pc) }}" class="banner-img" alt="{{ $banner->title }}">
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if($banner->image_mobile)
                            <img src="{{ asset('storage/' . $banner->image_mobile) }}" class="banner-img" alt="{{ $banner->title }}">
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $banner->title ?? '-' }}</td>

                    <td>
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" target="_blank">
                                {{ $banner->link_url }}
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $banner->sort_order }}</td>

                    <td>
                        @if($banner->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align:right;">
                        <div class="action-btns" style="justify-content:flex-end;">
                            <a href="{{ route('admin.gallery-banners.edit', $banner->gallery_banner_id) }}" class="action-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.gallery-banners.destroy', $banner->gallery_banner_id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Delete this banner?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="action-link delete">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:32px;">
                        No gallery banners found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $banners->links() }}
    </div>
</div>

@endsection