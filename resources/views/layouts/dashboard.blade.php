<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.components.header')
<body class="bg-gradient-primary">
    <div id="app">
        <main class="">
             <div id="wrapper">

                    <!-- Sidebar -->
                    @include('layouts.components.sidebar')
                    <!-- End of Sidebar -->

                    <!-- Content Wrapper -->
                    <div id="content-wrapper" class="d-flex flex-column">

                        <!-- Main Content -->
                        <div id="content">

                            <!-- Topbar -->
                            @include('layouts.components.topbar')
                            <!-- End of Topbar -->

                            <!-- Begin Page Content -->
                            @yield('content')

                            <!-- /.container-fluid -->

                        </div>
                        <!-- End of Main Content -->

                        <!-- Footer -->
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; Medic-Web 2025</span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->

                    </div>
                    <!-- End of Content Wrapper -->

                </div>
        </main>
        @include('components.modal-logout')
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('bootstrap-template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap-template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('bootstrap-template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('bootstrap-template/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        })
    </script>

    @include('script.script')
    @include('script.script-ajax')
    @stack('script')
</body>
</html>
