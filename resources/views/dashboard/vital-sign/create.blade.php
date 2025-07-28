@php
    $rndString = random_string();
@endphp
<tr>
    <td>
        <span class="rounded-0 input-group-text">{{ request()->rows }}</span>
    </td>
    <td>
        <select
            class="form-control rounded-0 select-vital detail-select"
            id="select_vital_{{ $rndString }}" name="detail[type_vital_id][]">
            <option value="" selected>Pilih</option>
            @foreach(typeVital() as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-value"
            value="0"
            required>
        <input
            type="hidden"
            name="detail[value][]"
            class="form-control rounded-0 value"
            value="0"
            >
    </td>
    <td>
        <button type="button" class="form-control rounded-0 del-form"><i class="fa fa-trash"></i></button>
    </td>
</tr>
