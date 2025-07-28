<div class="section">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                id="add-content-detail"
                                ref-url="{{ route('vital-sign.create') }}">Tambah Detail</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless" id="table-detail">
                            <thead>
                                <tr>
                                    <th width="10px">Nomer</th>
                                    <th width="500px">Tanda Vital</th>
                                    <th width="120px">Value</th>
                                    <th width="10px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody
                            @if(isset($item))
                                ref-idx="{{ $item->vitalSign->count() }}"
                            @endif
                            id="content-detail">
                            @if(isset($item))
                                @foreach($item->vitalSign as $key => $value)
                                    @include('dashboard.vital-sign.edit', [
                                        'item' => $value,
                                        'vital' => $item->vitalSign,
                                        'index' => $loop->iteration,
                                    ])
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{asset('css/form-detail.css')}}">
