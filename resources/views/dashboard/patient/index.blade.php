@extends('layouts.dashboard')
@push('title')
    {{ $title.' | '.config('app.name', 'Medic-Web') }}
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-end p-3">
                <a href="{{ route('patient.create') }}" class="btn btn-sm btn-outline-primary">Tambah</a>
            </div>
            <div class="d-flex justify-content-end p-3">
                <form action="{{ route('patient.index') }}" method="GET">
                    <x-search />
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                @include('components._table',[
                    'idtable' => 'table-patient',
                    'editurl' => 'patient.edit',
                    'destroyurl' => 'patient.destroy',
                    'refnama' => 'name',
                ])
            </div>
        </div>
    </div>
</div>
<x-modal id="modal-delete" label="Hapus {{ $title }}">
    @include('components._modal-destroy')
</x-modal>
@endsection
