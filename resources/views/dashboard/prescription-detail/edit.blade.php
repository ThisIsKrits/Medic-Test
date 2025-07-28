@php
    $rndString = random_string();
@endphp
<tr>
    <td>
        <span class="rounded-0 input-group-text">{{ $index }}</span>
    </td>
    <td>
        <select
            class="form-control rounded-0 select-inv detail-select"
            id="select_inv_{{ $rndString }}" name="detail[medicine][]">
           {!! select_medic($item->medicine) !!}
        </select>
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-qty"
            value="{{ human_number($item->qty) }}"
            required>
        <input
            type="hidden"
            name="detail[qty][]"
            class="form-control rounded-0 qty"
            value="{{ $item->qty }}"
            >
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-price"
            value="{{ human_number($item->price) }}"
            required>
        <input
            type="hidden"
            name="detail[price][]"
            class="form-control rounded-0 price"
            value="{{ $item->price }}"
            >
    </td>
    <td>
        <input
            type="text"
            class="form-control text-end rounded-0 show-subtotal"
            value="{{ human_number($item->subtotal) }}"
            required disabled>
        <input
            type="hidden"
            name="detail[subtotal][]"
            class="form-control rounded-0 subtotal"
            value="{{ $item->subtotal }}"
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
            ref-url="{{ route("prescription-detail.destroy", $item->id) }}"
            ref-nama="{{ $item->medicine }}">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
