@php
    $fieldKey = $field['key'];
    $selectedValue = old($fieldKey)
        ?? ($field['value'] ?? ($item->{$fieldKey} ?? null))
        ?? ($field['default_key'] ?? '');
@endphp

<select
    class="form-select select2 @error($fieldKey) is-invalid @enderror"
    id="{{ $fieldKey }}"
    name="{{ $fieldKey }}"
    @if(!empty($field['required'])) required @endif
    @if(!empty($field['disabled'])) disabled @endif
    @if(!empty($field['readonly'])) readonly @endif
>
    @if(empty($field['default_key']))
        <option value="">Pilih</option>
    @endif

    @isset($field['options'])
        @if(is_string($field['options']) && $field['options'] != strip_tags($field['options']))
            {!! $field['options'] !!}
        @else
            @foreach($field['options'] as $optionKey => $optionLabel)
                @continue($optionKey === "")
                <option
                    value="{{ $optionKey }}"
                    {{ $selectedValue == $optionKey ? 'selected' : '' }}
                >
                    @if(!empty($field['with_key']))
                        {{ $optionKey }} - {{ $optionLabel }}
                    @else
                        {{ $optionLabel }}
                    @endif
                </option>
            @endforeach
        @endif
    @endisset
</select>
