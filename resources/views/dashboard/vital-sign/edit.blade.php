@php
    $rndString = random_string();
@endphp
<tr>
    <td>
        <span class="input-group-text rounded-0">{{ $index }}</span>
    </td>
    <td>
        <select
            class="form-control rounded-0 select-vital detail-select"
            id="select_vital_{{ $rndString }}" name="detail[type_vital_id][]">
            <option value="" selected>Pilih</option>
            @foreach(typeVital() as $key => $value)
                <option value="{{ $key }}"
                @if($item->type_vital_id == $key) selected @endif
                >
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-value"
            value="{{ human_number($item->value) }}"
            required>
        <input
            type="hidden"
            name="detail[value][]"
            class="form-control rounded-0 value"
            value="{{ $item->value }}"
            >
    </td>
    <td>
        <input
            type="hidden"
            class="form-control rounded-0"
            name="detail[id][]"
            value="{{ $item->id }}">
        <button
            type="button"
            class="form-control rounded-0 del-detail"
            ref-url="{{ route("vital-sign.destroy", $item->id) }}"
            ref-nama="{{ $item->typeVital->name }}">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
