<h1>Add Option Group</h1>

<a href="{{ route('admin.option-groups.index') }}">
    Back
</a>

<br><br>

@if ($errors->any())
    <div style="color:red; margin-bottom: 15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.option-groups.store') }}" method="POST">
    @csrf

    <div>
        <label>Group Code</label><br>
        <input type="text" name="group_code" value="{{ old('group_code') }}" placeholder="เช่น pouch_type">
    </div>

    <br>

    <div>
        <label>Group Name</label><br>
        <input type="text" name="group_name" value="{{ old('group_name') }}" placeholder="เช่น ประเภทซอง">
    </div>
    
<br>
<div>
    <label>Parent Group</label><br>
    <select name="parent_group_id">
        <option value="">-- No Parent --</option>

        @foreach($parentGroups as $parent)
            <option 
                value="{{ $parent->option_group_id }}"
                {{ old('parent_group_id') == $parent->option_group_id ? 'selected' : '' }}
            >
                {{ $parent->group_name }}
            </option>
        @endforeach
    </select>

    @error('parent_group_id')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>

<br>

<div>
    <label>Help Text</label><br>
    <textarea 
        name="help_text" 
        rows="4"
        style="width:100%;"
        placeholder="ข้อความที่จะแสดงเมื่อกดปุ่ม info"
    >{{ old('help_text') }}</textarea>

    @error('help_text')
        <div style="color:red;">{{ $message }}</div>
    @enderror
</div>
    <br>

    <div>
        <label>Display Type</label><br>
        <select name="display_type">
            <option value="button" {{ old('display_type', 'button') == 'button' ? 'selected' : '' }}>
                button - ปุ่มข้อความ
            </option>

            <option value="image_card" {{ old('display_type') == 'image_card' ? 'selected' : '' }}>
                image_card - การ์ดรูปภาพ
            </option>

            <option value="color" {{ old('display_type') == 'color' ? 'selected' : '' }}>
                color - วงกลมสี
            </option>
            <option value="select_detail" {{ old('display_type') == 'select_detail' ? 'selected' : '' }}>
                select_detail - Dropdown พร้อมรูปและรายละเอียด
            </option>
            <option value="image_card_variant"
                {{ old('display_type', $optionGroup->display_type ?? '') == 'image_card_variant' ? 'selected' : '' }}>
                image_card_variant - การ์ดรูปภาพพร้อมเลือกสี
            </option>
            <option value="image_grid_compact" {{ old('display_type') == 'image_grid_compact' ? 'selected' : '' }}>
    image_grid_compact - การ์ดรูปภาพเล็กหลายคอลัมน์
</option>
<option value="grouped_buttons" {{ old('display_type') == 'grouped_buttons' ? 'selected' : '' }}>
    grouped_buttons - หัวข้อหลักพร้อมคำถามย่อยหลายชุด
</option>
<option value="previous_order_design" {{ old('display_type', $optionGroup->display_type ?? '') == 'previous_order_design' ? 'selected' : '' }}>
    previous_order_design - Yes/No + Previous Order No
</option>
        </select>

        @error('display_type')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Sort Order</label><br>
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">

        @error('sort_order')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>
<div>
    <label>
        <input 
            type="checkbox" 
            name="option_group_main" 
            value="1"
            {{ old('option_group_main') ? 'checked' : '' }}
        >
        Main Price Group
    </label>
    <br>
    <small>ติ๊กถ้า option group นี้ต้องใช้เป็นเงื่อนไขหลักใน Product Price Rules</small>
</div>

<br>
    <div>
        <label>
            <input type="checkbox" name="is_required" value="1" {{ old('is_required', 1) ? 'checked' : '' }}>
            Required
        </label>
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
