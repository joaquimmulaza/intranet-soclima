<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">


<title>Soclima Intranet | @yield('title')</title>

    <!--LOGO ICON -->
    <link rel="icon" href="{{asset('logo/img/iconLogoCorporatix120x142.png')}}">
    <link rel="stylesheet" href="">


    <!--FONT AWESOME -->
    <link rel="stylesheet" href="{{ url(mix('public/plugins/fontawesome-free/css/all.min.css'))}}">

    {{-- TEMPUSDOMINUS BOOTSTRAP 4--}}
    <link rel="stylesheet" href="{{ url(mix('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')) }}">

    <!-- jQuery -->
    <script src="{{ url(mix('public/plugins/jquery/jquery.min.js'))}}"></script>

    <!--STYLE ADMIN_LTE -->
    <link rel="stylesheet" href="{{ url(mix('public/dist/css/adminlte.min.css'))}}">

    {{--  CSS LOCAL:  SÓ COM ESTILO DE ONLINE E OFFLINE ** PARTIALS--}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    {{-- TEM ESTILO PARA VERIFICAR E COLOCAR NO CSS LOCAL--}}
    <link rel="stylesheet" href="{{asset('css/mdb.min.css')}}">

    {{-- TEM ESTILO IZI-TOAST--}}
    <link rel="stylesheet" href="{{asset('css/iziToast.css')}}">

     <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

