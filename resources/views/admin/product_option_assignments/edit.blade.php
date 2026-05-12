@extends('admin.layouts.app')

@section('title', 'Manage Product Options | Indigo Admin')
@section('css')
<style>
    .option-group-list {
    display: grid;
    gap: 18px;
}

.option-group-card {
    border: 1px solid var(--border);
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
}

.option-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    border-bottom: 1px solid var(--border);
    background: var(--bg);
}

.option-group-header h3 {
    margin: 0;
    font-size: 17px;
    color: var(--fg-dark);
}

.option-group-header span {
    color: var(--muted);
    font-size: 13px;
}

.option-list {
    padding: 8px 18px;
}

.option-row {
    padding: 14px 0;
    border-bottom: 1px solid var(--border);
}

.option-row:last-child {
    border-bottom: none;
}

.option-main-check {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: var(--fg-dark);
}

.option-main-check small {
    margin-left: 6px;
    color: var(--muted);
    font-weight: 500;
}

.option-setting {
    margin-top: 12px;
    margin-left: 28px;
    padding: 12px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 10px;
}

.option-setting-grid {
    display: grid;
    grid-template-columns: 180px 120px 120px;
    align-items: end;
    gap: 14px;
}

.option-setting-grid label {
    font-size: 13px;
    font-weight: 600;
    color: var(--fg-dark);
}

.option-setting-grid input[type="number"] {
    width: 100%;
    margin-top: 6px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 14px;
}

.mini-check {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 8px;
}

@media (max-width: 700px) {
    .option-setting-grid {
        grid-template-columns: 1fr;
    }

    .option-setting {
        margin-left: 0;
    }
}
.form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 28px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.btn-outline,
.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 38px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    font-family: inherit;
    line-height: 1;
}

.btn-outline {
    background: #fff;
    border: 1px solid var(--border);
    color: var(--fg);
}

.btn-outline:hover {
    background: var(--bg);
}

.btn-primary {
    background: var(--accent);
    border: 1px solid var(--accent);
    color: #fff;
}

.btn-primary:hover {
    background: var(--accent-hover);
}
</style>
@endsection

@section('content')

<div class="form-card">
    <div class="form-header">
        <div>
            <h1>Manage Options</h1>
            <p>{{ $product->product_name }}</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.options.update', $product->product_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="option-group-list">
            @foreach ($groups as $group)
                <div class="option-group-card">
                    <div class="option-group-header">
                        <h3>{{ $group->group_name }}</h3>
                        <span>{{ $group->options->count() }} options</span>
                    </div>

                    <div class="option-list">
                        @forelse ($group->options as $option)
                            @php
                                $isChecked = in_array((int) $option->option_id, $assignedOptionIds);
                                $pivot = $assignedPivot[$option->option_id]->pivot ?? null;
                            @endphp

                            <div class="option-row">
                                <label class="option-main-check">
                                    <input
                                        type="checkbox"
                                        class="option-checkbox"
                                        data-option-id="{{ $option->option_id }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                    >

                                    <span>
                                        {{ $option->option_name }}

                                        @if ($option->additional_price > 0)
                                            <small>
                                                +{{ number_format($option->additional_price, 2) }}
                                            </small>
                                        @endif
                                    </span>
                                </label>

                                <div
                                    class="option-setting option-setting-{{ $option->option_id }}"
                                    style="{{ $isChecked ? '' : 'display:none;' }}"
                                >
                                    <input
                                        type="hidden"
                                        name="options[{{ $option->option_id }}][option_id]"
                                        value="{{ $option->option_id }}"
                                        {{ $isChecked ? '' : 'disabled' }}
                                    >

                                    <div class="option-setting-grid">
                                        <label>
                                            Sort Order
                                            <input
                                                type="number"
                                                name="options[{{ $option->option_id }}][sort_order]"
                                                value="{{ $pivot->sort_order ?? 0 }}"
                                                min="0"
                                                {{ $isChecked ? '' : 'disabled' }}
                                            >
                                        </label>

                                        <label class="mini-check">
                                            <input
                                                type="checkbox"
                                                name="options[{{ $option->option_id }}][is_default]"
                                                value="1"
                                                {{ $pivot && $pivot->is_default ? 'checked' : '' }}
                                                {{ $isChecked ? '' : 'disabled' }}
                                            >
                                            Default
                                        </label>

                                        <label class="mini-check">
                                            <input
                                                type="checkbox"
                                                name="options[{{ $option->option_id }}][is_active]"
                                                value="1"
                                                {{ !$pivot || $pivot->is_active ? 'checked' : '' }}
                                                {{ $isChecked ? '' : 'disabled' }}
                                            >
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="muted-text">No options in this group.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-actions">
    <a href="{{ route('admin.products.index') }}" class="btn-outline">
        Cancel
    </a>

    <button type="submit" class="btn-primary">
        Save Options
    </button>
</div>
    </form>
</div>

<script>
    document.querySelectorAll('.option-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const optionId = this.dataset.optionId;
            const setting = document.querySelector('.option-setting-' + optionId);

            if (!setting) return;

            const inputs = setting.querySelectorAll('input');

            if (this.checked) {
                setting.style.display = 'block';

                inputs.forEach(function (input) {
                    input.disabled = false;
                });
            } else {
                setting.style.display = 'none';

                inputs.forEach(function (input) {
                    input.disabled = true;
                });
            }
        });
    });
</script>

@endsection