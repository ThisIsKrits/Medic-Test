
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 m-0">Form Edit {{ $title }}</h1>
        <a href="{{ route('checkup.index') }}" class="btn btn-sm btn-outline-danger">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>



    <div class="card shadow mb-4">
        <div class="card-body">
            <form
                class="form-horizontal"
                action="{{ route('checkup.update', $item) }}"
                method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @include('components.form',[
                    'withoutButton' => true
                ])

                @include('dashboard.checkup._form-detail',[
                    'item'  => $item
                ])

                @include('dashboard.checkup._form-document',[
                    'item'  => $item
                ])

                <div class="col-12 d-flex justify-content-end">
                    <x-button-save />
                </div>
            </form>
        </div>
    </div>
</div>
