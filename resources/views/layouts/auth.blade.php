<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.components.header')
<body class="bg-gradient-primary">
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>

     <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('components.modal-logout')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('bootstrap-template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap-template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('bootstrap-template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('bootstrap-template/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
