@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Selamat Datang <i>{{ Auth::user()->name }}</i></h1>

</div>
@endsection
