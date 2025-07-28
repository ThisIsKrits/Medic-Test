@php
    $rndString = random_string();
@endphp
<tr>
    <td>
        <span class="rounded-0 input-group-text">{{ request()->rows }}</span>
    </td>
    <td>
        <select
            class="form-control rounded-0 select-inv detail-select"
            id="select_inv_{{ $rndString }}" name="detail[medicine][]">
            {!! select_medic() !!}
        </select>
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-qty"
            value="0"
            required>
        <input
            type="hidden"
            name="detail[qty][]"
            class="form-control rounded-0 qty"
            value="0"
            >
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-price"
            value="0"
            required>
        <input
            type="hidden"
            name="detail[price][]"
            class="form-control rounded-0 price"
            value="0"
            >
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-subtotal"
            value="0"
            required disabled>
        <input
            type="hidden"
            name="detail[subtotal][]"
            class="form-control rounded-0 subtotal"
            value="0"
            >
    </td>
    <td>
        <button type="button" class="form-control rounded-0 del-form"><i class="fa fa-trash"></i></button>
    </td>
</tr>
