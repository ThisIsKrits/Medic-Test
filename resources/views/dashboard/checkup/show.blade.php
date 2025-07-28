<div class="modal-body">
    @include('components._default-show')

    <div class="card mb-3">
        <div class="card-body">
            @include('components._table',[
                'items' => $item->vitalSign,
                'fields' => $detailFields,
                'idtable' => 'table-detail',
                'action' => false,
            ])
        </div>
    </div>
    @if($item->checkupFile->count() > 0)
    <div class="card mb-3">
        <div class="card-body">
        @include('components._table',[
                'items' => $item->checkupFile,
                'fields' => $docFields,
                'idtable' => 'table-document',
                'refnama' => 'File',
                'action'    => false
            ])
        </div>
    </div>
    @endif
</div>
<div class="modal-footer">
    <div class="col text-end">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
    </div>
</div>
