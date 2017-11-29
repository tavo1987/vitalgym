<!DOCTYPE html>
<html lang="es">
@include('layouts.partials.htmlheader')
<body class="skin-black fixed">
    <div class="wrapper" id="app">
        <div id="loader">
            <img src="{{ asset('/img/rolling.svg') }}" alt="loader">
        </div>
        @include('layouts.partials.mainheader')
        @include('layouts.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
           @include('layouts.partials.contentheader')
            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('main-content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('layouts.partials.footer')
    </div><!-- ./wrapper -->
    @include('layouts.partials.scripts')
</body>
</html>
