<input
    type="{{ $field['type'] }}"
    class="form-control @error($field['key']) is-invalid @enderror""
    id="{{ $field['key'] }}"
    name="{{ $field['key'] }}"
    @if($field['required'] == 1)
        required
    @endif>
