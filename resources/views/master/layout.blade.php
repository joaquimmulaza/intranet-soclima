<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        

        @include('master.partials_master._head')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    </head>
@if(Auth::user() != null)
    <body class="hold-transition sidebar-mini {{Route::current()->getName() == 'post.show' || 'home' ? 'sidebar-collapse' : 'layout-fixed'}}">

    <div class="wrapper">
        {{-- NAVBAR BARRA TOPO--}}
        @include('master.partials_master._nav')

        {{-- SIDEBAR LATERAL--}}
        @include('master.partials_master._sidebar')

        {{-- CONTEÚDO DAS PÁGINAS--}}
        <div class="content-wrapper bg-home" style="margin: 0 !important;">
            @yield('content')


        {{-- RODAPÉ --}}
        @include('master.partials_master._footer')
        </div>
    </div>
@else
    <script>window.location = "{{route('home')}}";</script>
    <?php exit;?>
@endif
    {{-- ADMINLTE JS--}}
    <script src="{{ url(mix('public/dist/js/adminlte.js'))}}"></script>
    {{-- IZI-TOAST PARA MENSAGENS--}}
    <script src="{{ asset('js/iziToast.js') }}"></script>
    {{-- --}}
    @include('vendor.lara-izitoast.toast')
    {{-- --}}
    @yield('partialspost_js')
    {{-- --}}
    <script src="{{ asset('js/mdb.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            timer: 6000,
            position: "bottom-start",
            imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
            imageAlt: "Custom image",
            imageWidth: 40,
            title: '{{ session('success') }}',
            showConfirmButton: false,
            width: 225,
            backdrop: false,
            customClass: {
                popup: 'container_sweet_justificativos',
                icon: 'icon_sweet_justificativos',
                title: 'title_sweet_justificativos',
                image: 'img_sweet_justificativos'
            }
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            timer: 6000,
            position: "bottom-start",
            imageUrl: "{{asset('logo/img/icon/failed.svg')}}",
            imageAlt: "Custom image",
            title: '{{ session('error') }}',
            showConfirmButton: false,
            width: 225,
            backdrop: false,
            customClass: {
                popup: 'container_sweet_justificativos',
                icon: 'icon_sweet_justificativos',
                title: 'title_sweet_justificativos',
                image: 'img_sweet_justificativos'
            }
        });
    </script>
@endif

</body>
</html>
