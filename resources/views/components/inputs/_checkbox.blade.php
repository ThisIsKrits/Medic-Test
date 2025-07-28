<div class="form-check d-flex align-items-center">
    <input class="form-check-input" type="{{ $field['type'] }}"
        name="{{ $field['key'] }}"
        value="" id="{{ $field['key'] }}"
        data-on="1"
        data-off="0"
        @if($field['required'] == 1)
        required
        @endif
        @if(old($field['key'], isset($item) ? $item->{$field['key']} : 0) == 1) checked @elseif( isset($item) && check_tax($item->id, true) == 'Y') checked @endif>
    <label class="form-check-label ms-1" id="label-{{ $field['key'] }}" for="{{ $field['key'] }}"></label>
</div>
