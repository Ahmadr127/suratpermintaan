@props([
    'name',
    'label' => null,
    'value' => '',
    'rows' => 5,
    'placeholder' => '',
    'class' => '',
])

@php $uid = 'tmce_' . uniqid(); @endphp

<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $uid }}">{{ $label }}</label>
    @endif
    <textarea id="{{ $uid }}" name="{{ $name }}" class="form-control {{ $class }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
</div>

@once
<script src="/tinymce/js/tinymce/tinymce.min.js"></script>
@endonce
<script>
    (function () {
        var selector = '#{{ $uid }}';
        if (typeof tinymce === 'undefined') return;
        tinymce.init({
            selector: selector,
            base_url: '/tinymce/js/tinymce',
            suffix: '.min',
            height: {{ $rows * 30 + 120 }},
            menubar: false,
            plugins: 'lists link table code searchreplace fullscreen visualblocks',
            toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link table | code fullscreen',
            min_height: 120,
            license_key: 'gpl',
            entity_encoding: 'raw',
            convert_urls: false,
            branding: false,
            promotion: false,
            setup: function (editor) {
                editor.on('change input undo redo', function () {
                    editor.save();
                    var ta = document.querySelector(selector);
                    if (ta) ta.dispatchEvent(new Event('input', { bubbles: true }));
                });
            }
        });
    })();
</script>
