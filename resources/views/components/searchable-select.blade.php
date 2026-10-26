@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih...',
    'required' => false,
    'class' => '',
])

@php $uid = 'ss_' . uniqid(); @endphp

<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $uid }}">{{ $label }}</label>
    @endif
    <select id="{{ $uid }}" name="{{ $name }}" class="form-select {{ $class }}" {{ $required ? 'required' : '' }}>
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ (string) $selected === (string) $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>

@once
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endonce

<script>
    (function () {
        var $ = window.jQuery;
        if (!$) return;
        $(function () {
            $('#{{ $uid }}').select2({
                width: '100%',
                placeholder: '{{ $placeholder }}',
                allowClear: true
            });
        });
    })();
</script>
