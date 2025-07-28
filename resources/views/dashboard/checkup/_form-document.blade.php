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
                                id="add-content-document"
                                ref-url="{{ route('checkup-file.create') }}">Tambah File</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless text-center" id="table-document">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="500px">Dokumen</th>
                                    <th width="500px">Preview</th>
                                    <th width="10px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody
                            @if(isset($item))
                                ref-idx="{{ $item->checkupFile->count() }}"
                            @endif
                            id="content-document">
                            @if(isset($item))
                                @foreach($item->checkupFile as $key => $value)
                                    @include('dashboard.checkup-file.edit', [
                                        'item' => $value,
                                        'index' => $loop->iteration
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

<link rel="stylesheet" href="{{asset('css/additional.css')}}">
<link rel="stylesheet" href="{{asset('css/form-detail.css')}}">
