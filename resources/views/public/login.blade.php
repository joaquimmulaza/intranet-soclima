@include('public.partials._headLogin')
<title>Logar no sistema</title>

<body id="intro-login" class="hold-transition login-page">
    <div class="bg-image"></div>
    <div class="login-box">
        <!-- LOGO -->
        <div class="login-logo">
            <img src="{{asset('logo/img/logo250x62.png')}}" alt="Logo" style="opacity: .8">
        </div>

        <!-- FORM LOGIN -->
        <div class="card">
            <div class="card-body login-card-body rounded">
                <p class="login-box-msg">Faça seu login para iniciar a sessão</p>

                <form action="{{route('admin.login.do')}}" method="post">
                    @csrf
                    @include('public.partials._errors')

                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn-shadow btn btn-md btn-deep-purple btn-block">
                                <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fas fa-sign-in-alt"></i>
                                </span>
                                Entrar
                            </button>
                        </div>
                    </div>
                </form>


                <p class="social-auth-links text-center mb-3">- ou acesse por sua conta -</p>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a href="{{route('user.facebook')}}" class="btn btn-md blue darken-1 d-flex rounded">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fab fa-facebook"></i>
                            </span>
                            Facebook
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a href="{{route('user.google')}}" class="btn btn-md red darken-1 d-flex rounded">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fab fa-google-plus"></i>
                            </span>
                             Google+
                        </a>
                    </div>

                    {{--<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <a href="{{route('user.github')}}" class="btn btn-block btn-outline-elegant d-flex">
                            <i class="fab fa-github mr-2 mt-1"></i> GitHub
                        </a>
                    </div>--}}

                </div>
            </div>

        </div>
    </div>

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('user.register') }}" class="btn-shadow btn btn-md teal lighten-2 rounded">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-arrow-circle-right"></i>
                        </span>
                        Cadastre-se agora
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url(mix('public/dist/js/adminlte.js'))}}"></script>
    <script src="{{ asset('frontend/login/script.js') }}"></script>
</body>
</html>
