@if(isset($field['has_show']) && $field['has_show'] == true)
    <input
        type="text"
        class="form-control @error($field['key']) is-invalid @enderror"
        id="show-form-{{ $field['key'] }}"
        value="{{ old($field['key'], isset($item) ?
            human_number($item->{$field['key']}) :
            human_number($defaultValue)) }}"
        @if($field['required'] == 1)
            required
        @endif
        @if(isset($field['is_tax']) && $field['is_tax'] == true)
            min = 0
            max = 100
            step="any"
            onKeyUp="if(this.value>='100'){this.value='100';}else if(this.value<='0'){this.value='0';}"
        @endif
        @if(isset($field['disabled']) && $field['disabled'])
            disabled
        @endif>
    <input
        type="hidden"
        class="form-control"
        id="{{ $field['key'] }}"
        name="{{ $field['key'] }}"
        value="{{ old($field['key'], isset($item) ? $item->{$field['key']} : $defaultValue) }}">
@else
    <input
        type="{{ $field['type'] }}"
        class="form-control @error($field['key']) is-invalid @enderror""
        id="{{ $field['key'] }}"
        name="{{ $field['key'] }}"
        value="{{ old($field['key'], isset($item) ? $item->{$field['key']} : $defaultValue) }}"
        @if($field['required'] == 1)
            required
        @endif
        @if(isset($field['disabled']) && $field['disabled'])
            disabled
        @endif
        @if(isset($field['readonly']) && $field['readonly'])
            readonly
        @endif>
@endif
