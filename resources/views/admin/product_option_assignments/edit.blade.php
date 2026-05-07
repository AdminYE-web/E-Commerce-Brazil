<h1>Manage Options: {{ $product->product_name }}</h1>

<a href="{{ route('admin.products.index') }}">
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

<form action="{{ route('admin.products.options.update', $product->product_id) }}" method="POST">
    @csrf
    @method('PUT')

    @foreach($groups as $group)
        <div style="border:1px solid #ddd; padding:15px; margin-bottom:20px;">
            <h3>{{ $group->group_name }}</h3>

            @forelse($group->options as $option)
                @php
                    $isChecked = in_array((int) $option->option_id, $assignedOptionIds);
                    $pivot = $assignedPivot[$option->option_id]->pivot ?? null;
                @endphp

                <div style="padding:10px; border-bottom:1px solid #eee;">
                    <label>
                        <input 
                            type="checkbox" 
                            class="option-checkbox"
                            data-option-id="{{ $option->option_id }}"
                            {{ $isChecked ? 'checked' : '' }}
                        >

                        {{ $option->option_name }}
                        @if($option->additional_price > 0)
                            (+{{ number_format($option->additional_price, 2) }})
                        @endif
                    </label>

                    <div 
                        class="option-setting option-setting-{{ $option->option_id }}"
                        style="{{ $isChecked ? '' : 'display:none;' }} margin-top:8px; margin-left:25px;"
                    >
                        <input 
                            type="hidden" 
                            name="options[{{ $option->option_id }}][option_id]" 
                            value="{{ $option->option_id }}"
                            {{ $isChecked ? '' : 'disabled' }}
                        >

                        <label>
                            Sort:
                            <input 
                                type="number" 
                                name="options[{{ $option->option_id }}][sort_order]" 
                                value="{{ $pivot->sort_order ?? 0 }}"
                                min="0"
                                {{ $isChecked ? '' : 'disabled' }}
                            >
                        </label>

                        &nbsp;

                        <label>
                            <input 
                                type="checkbox" 
                                name="options[{{ $option->option_id }}][is_default]" 
                                value="1"
                                {{ $pivot && $pivot->is_default ? 'checked' : '' }}
                                {{ $isChecked ? '' : 'disabled' }}
                            >
                            Default
                        </label>

                        &nbsp;

                        <label>
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
            @empty
                <p>No options in this group.</p>
            @endforelse
        </div>
    @endforeach

    <button type="submit">Save Options</button>
</form>

<script>
    document.querySelectorAll('.option-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const optionId = this.dataset.optionId;
            const setting = document.querySelector('.option-setting-' + optionId);
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