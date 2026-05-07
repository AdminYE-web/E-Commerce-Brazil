<h1>Edit Product Detail</h1>

<a href="{{ route('admin.product-details.index') }}">
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

<form action="{{ route('admin.product-details.update', $detail->product_detail_id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label>Product</label><br>
        <select name="product_id">
            <option value="">-- Select Product --</option>

            @foreach ($products as $product)
                <option value="{{ $product->product_id }}"
                    {{ old('product_id', $detail->product_id) == $product->product_id ? 'selected' : '' }}>
                    {{ $product->product_name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    {{-- <div>
        <label>Current Sample Image</label><br>

        @if ($detail->sample_image)
            <img 
                src="{{ asset('storage/' . $detail->sample_image) }}" 
                width="150"
            >
        @else
            <span>No image</span>
        @endif
    </div>

    <br> --}}
    <div>
        <label>Current Specification Image</label><br>

        @if ($detail->specification_image)
            <img src="{{ asset('storage/' . $detail->specification_image) }}" width="180"
                style="display:block; margin-bottom:10px;">
        @else
            <span>No image</span>
        @endif
    </div>

    <br>

    <div>
        <label>Change Specification Image</label><br>
        <input type="file" name="specification_image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Change Sample Image</label><br>
        <input type="file" name="sample_image" accept="image/*">
    </div>

    <br>

    <div>
        <label>Detail Content</label><br>

        <div id="detail-content-wrapper">
            @php
                $oldDetails = old(
                    'detail_content',
                    $detail->detail_content ?? [
                        [
                            'headline' => '',
                            'desc' => '',
                            'icon_image' => '',
                        ],
                    ],
                );

                if (empty($oldDetails)) {
                    $oldDetails = [
                        [
                            'headline' => '',
                            'desc' => '',
                            'icon_image' => '',
                        ],
                    ];
                }
            @endphp

            @foreach ($oldDetails as $index => $item)
                <div class="detail-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Detail Set <span class="detail-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Headline</label><br>
                        <input type="text" name="detail_content[{{ $index }}][headline]"
                            value="{{ $item['headline'] ?? '' }}" style="width:100%;">
                    </div>

                    <br>

                    <div>
                        <label>Description</label><br>
                        <textarea name="detail_content[{{ $index }}][desc]" rows="4" style="width:100%;">{{ $item['desc'] ?? '' }}</textarea>
                    </div>

                    <br>

                    <div>
                        <label>Current Icon Image</label><br>

                        @if (!empty($item['icon_image']))
                            <img src="{{ asset('storage/' . $item['icon_image']) }}" width="50"
                                style="display:block; margin-bottom:8px;">
                        @else
                            <span>No icon image</span>
                        @endif

                        <input type="hidden" name="detail_content[{{ $index }}][icon_image]"
                            value="{{ $item['icon_image'] ?? '' }}">
                    </div>

                    <br>

                    <div>
                        <label>Change Icon Image</label><br>
                        <input type="file" name="detail_icon_images[{{ $index }}]" accept="image/*">
                    </div>

                    <br>

                    <button type="button" class="remove-detail-item">
                        Remove
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-detail-item">
            + Add Detail Set
        </button>

    </div>

    
    <br>

<div>
        <label>Specification Content</label><br>

        <div id="spec-content-wrapper">
            @php
                $oldSpecs = old(
                    'specification_content',
                    $detail->specification_content ?? [
                        [
                            'title' => '',
                            'desc' => '',
                            'icon_image' => '',
                        ],
                    ],
                );

                if (empty($oldSpecs)) {
                    $oldSpecs = [
                        [
                            'title' => '',
                            'desc' => '',
                            'icon_image' => '',
                        ],
                    ];
                }
            @endphp

            @foreach ($oldSpecs as $index => $item)
                <div class="spec-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Spec Set <span class="spec-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Title</label><br>
                        <input type="text" name="specification_content[{{ $index }}][title]"
                            value="{{ $item['title'] ?? '' }}" style="width:100%;" placeholder="เช่น Width Options:">
                    </div>

                    <br>

                    <div>
                        <label>Description</label><br>
                        <textarea name="specification_content[{{ $index }}][desc]" rows="3" style="width:100%;"
                            placeholder="เช่น 10mm, 15mm, 20mm, and more">{{ $item['desc'] ?? '' }}</textarea>
                    </div>

                    <br>
                    <br>

                    <div>
                        <label>Link Text</label><br>
                        <input type="text" name="specification_content[{{ $index }}][link_text]"
                            value="{{ $item['link_text'] ?? '' }}" style="width:100%;"
                            placeholder="เช่น View more colors">
                    </div>

                    <br>

                    <div>
                        <label>Link URL</label><br>
                        <input type="text" name="specification_content[{{ $index }}][link_url]"
                            value="{{ $item['link_url'] ?? '' }}" style="width:100%;"
                            placeholder="เช่น /colors หรือ https://example.com">
                    </div>

                    <div>
                        <label>Current Spec Icon</label><br>

                        @if (!empty($item['icon_image']))
                            <img src="{{ asset('storage/' . $item['icon_image']) }}" width="45"
                                style="display:block; margin-bottom:8px;">
                        @else
                            <span>No icon image</span>
                        @endif

                        <input type="hidden" name="specification_content[{{ $index }}][icon_image]"
                            value="{{ $item['icon_image'] ?? '' }}">
                    </div>

                    <br>

                    <div>
                        <label>Change Spec Icon</label><br>
                        <input type="file" name="spec_icon_images[{{ $index }}]" accept="image/*">
                    </div>

                    <br>

                    <button type="button" class="remove-spec-item">
                        Remove Spec
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-spec-item">
            + Add Spec Set
        </button>
    </div>

    <br>

    <div>
        <label>Accordion Content</label><br>

        <div id="accordion-content-wrapper">
            @php
                $oldAccordions = old(
                    'accordion_content',
                    $detail->accordion_content ?? [
                        [
                            'title' => '',
                            'content' => '',
                        ],
                    ],
                );

                if (empty($oldAccordions)) {
                    $oldAccordions = [
                        [
                            'title' => '',
                            'content' => '',
                        ],
                    ];
                }
            @endphp

            @foreach ($oldAccordions as $index => $item)
                <div class="accordion-item-admin" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                    <h4>Accordion Set <span class="accordion-number">{{ $index + 1 }}</span></h4>

                    <div>
                        <label>Title</label><br>
                        <input type="text" name="accordion_content[{{ $index }}][title]"
                            value="{{ $item['title'] ?? '' }}" style="width:100%;" placeholder="เช่น Production fee">
                    </div>

                    <br>

                    <div>
                        <label>Content</label><br>
                        <textarea name="accordion_content[{{ $index }}][content]" class="accordion-ckeditor" rows="8"
                            style="width:100%;">{{ $item['content'] ?? '' }}</textarea>
                    </div>

                    <br>

                    <button type="button" class="remove-accordion-item">
                        Remove Accordion
                    </button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-accordion-item">
            + Add Accordion Set
        </button>
    </div>

    <br>

    <div>
        <label>
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $detail->is_active) ? 'checked' : '' }}>
            Active
        </label>
    </div>

    <br>

    <button type="submit">Update</button>
</form>

<script>
    let specIndex = document.querySelectorAll('.spec-item').length;

    document.getElementById('add-spec-item').addEventListener('click', function() {
        const wrapper = document.getElementById('spec-content-wrapper');

        const html = `
        <div class="spec-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
            <h4>Spec Set <span class="spec-number">${specIndex + 1}</span></h4>

            <div>
                <label>Title</label><br>
                <input 
                    type="text" 
                    name="specification_content[${specIndex}][title]" 
                    value=""
                    style="width:100%;"
                    placeholder="เช่น Width Options:"
                >
            </div>

            <br>

            <div>
                <label>Description</label><br>
                <textarea 
                    name="specification_content[${specIndex}][desc]" 
                    rows="3"
                    style="width:100%;"
                    placeholder="เช่น 10mm, 15mm, 20mm, and more"
                ></textarea>
            </div>
<br>

<div>
    <label>Link Text</label><br>
    <input 
        type="text" 
        name="specification_content[${specIndex}][link_text]" 
        value=""
        style="width:100%;"
        placeholder="เช่น View more colors"
    >
</div>

<br>

<div>
    <label>Link URL</label><br>
    <input 
        type="text" 
        name="specification_content[${specIndex}][link_url]" 
        value=""
        style="width:100%;"
        placeholder="เช่น /colors หรือ https://example.com"
    >
</div>
            <br>
            

            <div>
                <label>Spec Icon</label><br>
                <input 
                    type="hidden" 
                    name="specification_content[${specIndex}][icon_image]" 
                    value=""
                >

                <input 
                    type="file" 
                    name="spec_icon_images[${specIndex}]" 
                    accept="image/*"
                >
            </div>

            <br>

            <button type="button" class="remove-spec-item">
                Remove Spec
            </button>
        </div>
    `;

        wrapper.insertAdjacentHTML('beforeend', html);
        specIndex++;
        updateSpecNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-spec-item')) {
            const items = document.querySelectorAll('.spec-item');

            if (items.length <= 1) {
                alert('ต้องมี Spec อย่างน้อย 1 ชุด');
                return;
            }

            e.target.closest('.spec-item').remove();
            updateSpecNumbers();
        }
    });

    function updateSpecNumbers() {
        document.querySelectorAll('.spec-item').forEach(function(item, index) {
            item.querySelector('.spec-number').innerText = index + 1;
        });
    }
    let detailIndex = document.querySelectorAll('.detail-item').length;

    document.getElementById('add-detail-item').addEventListener('click', function() {
        const wrapper = document.getElementById('detail-content-wrapper');

        const html = `
            <div class="detail-item" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Detail Set <span class="detail-number">${detailIndex + 1}</span></h4>

                <div>
                    <label>Headline</label><br>
                    <input 
                        type="text" 
                        name="detail_content[${detailIndex}][headline]" 
                        value=""
                        style="width:100%;"
                    >
                </div>

                <br>

                <div>
                    <label>Description</label><br>
                    <textarea 
                        name="detail_content[${detailIndex}][desc]" 
                        rows="4"
                        style="width:100%;"
                    ></textarea>
                </div>

                <br>

                <div>
                    <label>Icon Image</label><br>
                    <input 
                        type="hidden" 
                        name="detail_content[${detailIndex}][icon_image]" 
                        value=""
                    >

                    <input 
                        type="file" 
                        name="detail_icon_images[${detailIndex}]" 
                        accept="image/*"
                    >
                </div>

                <br>

                <button type="button" class="remove-detail-item">
                    Remove
                </button>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        detailIndex++;
        updateDetailNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail-item')) {
            const items = document.querySelectorAll('.detail-item');

            if (items.length <= 1) {
                alert('ต้องมี Detail อย่างน้อย 1 ชุด');
                return;
            }

            e.target.closest('.detail-item').remove();
            updateDetailNumbers();
        }
    });

    function updateDetailNumbers() {
        document.querySelectorAll('.detail-item').forEach(function(item, index) {
            item.querySelector('.detail-number').innerText = index + 1;
        });
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    const accordionEditors = {};

    function initAccordionEditor(textarea) {
        if (!textarea || textarea.dataset.editorReady === '1') {
            return;
        }

        const editorKey = textarea.getAttribute('name');

        ClassicEditor
            .create(textarea)
            .then(function(editor) {
                accordionEditors[editorKey] = editor;
                textarea.dataset.editorReady = '1';
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function initAllAccordionEditors() {
        document.querySelectorAll('.accordion-ckeditor').forEach(function(textarea) {
            initAccordionEditor(textarea);
        });
    }

    initAllAccordionEditors();

    let accordionIndex = document.querySelectorAll('.accordion-item-admin').length;

    document.getElementById('add-accordion-item').addEventListener('click', function() {
        const wrapper = document.getElementById('accordion-content-wrapper');

        const html = `
            <div class="accordion-item-admin" style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
                <h4>Accordion Set <span class="accordion-number">${accordionIndex + 1}</span></h4>

                <div>
                    <label>Title</label><br>
                    <input 
                        type="text" 
                        name="accordion_content[${accordionIndex}][title]" 
                        value=""
                        style="width:100%;"
                        placeholder="เช่น Production fee"
                    >
                </div>

                <br>

                <div>
                    <label>Content</label><br>
                    <textarea 
                        name="accordion_content[${accordionIndex}][content]" 
                        class="accordion-ckeditor"
                        rows="8"
                        style="width:100%;"
                    ></textarea>
                </div>

                <br>

                <button type="button" class="remove-accordion-item">
                    Remove Accordion
                </button>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);

        const newTextarea = wrapper.querySelector(
            `textarea[name="accordion_content[${accordionIndex}][content]"]`
        );

        initAccordionEditor(newTextarea);

        accordionIndex++;
        updateAccordionNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-accordion-item')) {
            const items = document.querySelectorAll('.accordion-item-admin');

            if (items.length <= 1) {
                alert('ต้องมี Accordion อย่างน้อย 1 ชุด');
                return;
            }

            const item = e.target.closest('.accordion-item-admin');
            const textarea = item.querySelector('.accordion-ckeditor');

            if (textarea) {
                const editorKey = textarea.getAttribute('name');

                if (accordionEditors[editorKey]) {
                    accordionEditors[editorKey].destroy();
                    delete accordionEditors[editorKey];
                }
            }

            item.remove();
            updateAccordionNumbers();
        }
    });

    function updateAccordionNumbers() {
        document.querySelectorAll('.accordion-item-admin').forEach(function(item, index) {
            item.querySelector('.accordion-number').innerText = index + 1;
        });
    }
</script>
