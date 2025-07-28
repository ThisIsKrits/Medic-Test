@extends('layouts.dashboard')
@push('title')
    {{ $title.' | '.config('app.name', 'Medic-Web') }}
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 m-0">Form Tambah {{ $title }}</h1>
        <a href="{{ route('type-vital.index') }}" class="btn btn-sm btn-outline-danger">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form
                class="form-horizontal"
                action="{{ route('type-vital.store') }}"
                method="POST">
                @method('POST')
                @csrf
                @include('components.form')
            </form>
        </div>
    </div>
</div>
@endsection
