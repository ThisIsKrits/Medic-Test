@extends('layouts.dashboard')
@push('title')
    {{ $title.' | '.config('app.name', 'Medic-Web') }}
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 m-0">Form Edit {{ $title }}</h1>
        <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-danger">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>



    <div class="card shadow mb-4">
        <div class="card-body">
            <form
                class="form-horizontal"
                action="{{ route('user.update', $item) }}"
                method="POST">
                @method('PUT')
                @csrf
                @include('components.form')
            </form>
        </div>
    </div>
</div>
@endsection
