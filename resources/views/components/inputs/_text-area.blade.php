<textarea
    class="form-control @error($field['key']) is-invalid @enderror"
    id="{{ $field['key'] }}"
    name="{{ $field['key'] }}"
    rows="{{ isset($field['rows']) ? $field['rows'] : 5 }}"
    @if(isset($field['disabled']) && $field['disabled'])
        disabled
    @endif
    @if($field['required'] == 1)
        required
@endif>{{ old($field['key'], isset($item) ? $item->{$field['key']} : $defaultValue) }}</textarea>
