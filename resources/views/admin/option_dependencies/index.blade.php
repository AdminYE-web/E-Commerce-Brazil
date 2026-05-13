@extends('admin.layouts.app')

@section('title', 'Option Dependencies | Indigo Admin')

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

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        padding: 9px 18px;
        border-radius: 8px;
        background: var(--accent);
        border: 1px solid var(--accent);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
        line-height: 1;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
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

    .action-link:hover {
        text-decoration: underline;
    }

    .action-link.delete {
        color: #dc2626;
    }

    .mini-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 12px;
        color: var(--fg);
        white-space: nowrap;
    }

    .dependency-text {
        line-height: 1.5;
        font-size: 14px;
    }

    .dependency-sub {
        display: block;
        color: var(--muted);
        font-size: 12px;
        margin-bottom: 2px;
    }

    @media (max-width: 900px) {
        .table-card {
            overflow-x: auto;
        }

        table {
            min-width: 1000px;
        }

        .table-header {
            align-items: flex-start;
            gap: 14px;
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')

<div class="table-card">
    <div class="table-header">
        <div>
            <div class="table-title">Option Dependencies</div>
            <div class="showing-text">
                Manage conditional display rules between product options and option groups.
            </div>
        </div>

        <div class="table-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-outline">
                Dashboard
            </a>

            <a href="{{ route('admin.option-dependencies.create') }}" class="btn-primary">
                + Add Dependency
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
                <th>Trigger Option</th>
                <th>Target Type</th>
                <th>Target</th>
                <th>Sort</th>
                <th>Status</th>
                <th style="text-align: right;">Manage</th>
            </tr>
        </thead>

        <tbody>
            @forelse($dependencies as $dependency)
                <tr>
                    <td>
                        <div class="dependency-text">
                            <span class="dependency-sub">
                                ID: {{ $dependency->dependency_id }}
                            </span>

                            {{ $dependency->parentOption->group->group_name ?? '-' }}
                            /
                            <strong>{{ $dependency->parentOption->option_name ?? '-' }}</strong>
                        </div>
                    </td>

                    <td>
                        <span class="mini-badge">
                            {{ $dependency->target_type }}
                        </span>
                    </td>

                    <td>
                        <div class="dependency-text">
                            @if($dependency->target_type === 'group')
                                <span class="dependency-sub">Group</span>
                                <strong>{{ $dependency->targetGroup->group_name ?? '-' }}</strong>
                            @else
                                <span class="dependency-sub">Option</span>
                                {{ $dependency->targetOption->group->group_name ?? '-' }}
                                /
                                <strong>{{ $dependency->targetOption->option_name ?? '-' }}</strong>
                            @endif
                        </div>
                    </td>

                    <td>{{ $dependency->sort_order }}</td>

                    <td>
                        @if($dependency->is_active)
                            <span class="status-pill status-active">Active</span>
                        @else
                            <span class="status-pill status-inactive">Inactive</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.option-dependencies.edit', $dependency->dependency_id) }}"
                               class="action-link">
                                Edit
                            </a>

                            <form action="{{ route('admin.option-dependencies.destroy', $dependency->dependency_id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="action-link delete"
                                        onclick="return confirm('Delete this dependency?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 32px;">
                        No dependencies found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $dependencies->links() }}
    </div>
</div>

@endsection