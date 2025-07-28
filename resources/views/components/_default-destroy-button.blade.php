@php
    $btnDelClass = isset($destroyClass) && $destroyClass != '' ? $destroyClass : 'btn-delete-data';
    $delTargetModal = isset($delTargetModal) && $delTargetModal != '' ? $delTargetModal : '#modal-delete';
@endphp
<a
    href="#"
    class="btn btn-sm btn-link px-1 {{ $btnDelClass }}"
    data-toggle="modal"
    data-target="{{ $delTargetModal }}"
    ref-url="{{ $destroyurl }}"
    ref-nama="{{ $refnama }}"
    data-tooltip="tooltip"
    data-bs-placement="top"
    title="Hapus Data">
    <i class="fa-solid fa-trash icon_action text-danger" aria-hidden="true"></i>
</a>
