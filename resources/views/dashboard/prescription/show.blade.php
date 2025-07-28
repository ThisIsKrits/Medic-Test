<div class="modal-body">
    @include('components._default-show')

    <div class="card mb-3">
        <div class="card-body">
            @include('components._table',[
                'items' => $item->prescriptionItems,
                'fields' => $detailFields,
                'idtable' => 'table-detail',
                'action' => false,
            ])
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row w-100 justify-content-between">
        <div class="col-auto d-flex gap-2">
            <div class="update-status">
                @if ($item->status != 2 && (Auth::user()->hasRole('apoteker') || Auth::user()->hasRole('superadmin')))
                    <form action="{{ route('prescription-update.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </form>
                @endif
            </div>

            @if ($item->status == 2)
                <div class="print">
                    <a href="{{ route('prescription-update.show', $item->id) }}" target="_blank" class="btn btn-outline-success">
                        Print
                    </a>
                </div>
            @endif
        </div>

        <div class="col-auto">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>

