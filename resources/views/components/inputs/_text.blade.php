<input
    type="{{ $field['type'] }}"
    class="form-control @error($field['key']) is-invalid @enderror"
    id="{{ $field['key'] }}"
    name="{{ $field['key'] }}"
    value="{{ old($field['key'], isset($item) ? $item->{$field['key']} : $defaultValue) }}"
    @if($field['required'] == 1)
        required
    @endif
    @if(isset($field['disabled']) && $field['disabled'] == true)
            disabled
    @endif
    @if(isset($field['readonly']) && $field['readonly'])
        readonly
    @endif>
