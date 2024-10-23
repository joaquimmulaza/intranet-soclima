@include('public.partials._headLogin')
<title>Logar no sistema</title>



<body id="intro-login" class="hold-transition login-page">
    <div class="bg-image"></div>
    <div class="login-box">
        

        <!-- FORM LOGIN -->
        <p class="login-box-msg" style="position:relative; z-index: 9999; color: #fff; font-size: 48px; font-weight: bold; width: 100%;">SEJA BEM-VINDO(A)</p>
        <div class="card">
        
            <div class="card-body login-card-body borderRadius">
                <!-- <p class="login-box-msg">Faça seu login para iniciar a sessão</p> -->
                <!-- LOGO -->
                

                <form action="{{route('admin.login.do')}}" class="centerBox fullContainer" method="post">
                    <div class="login-logo login-box-msg">
                        <img src="{{asset('logo/img/logo250x62.png')}}" alt="Logo">
                    </div>
                    @csrf
                    @include('public.partials._errors')

                    <div class=" fullContainer">
                        <label for="email">ID do trabalhador</label>
                        <input type="email" name="email" class="form-control inputLogin" placeholder="Email">
                        {{-- <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div> --}}
                    </div>
                    <div class=" fullContainer ">
                        <label for="password">Palavra-passe</label>
                        <div class="eyeHidden">
                            <input type="password" name="password" id="password" class="form-control inputLogin" placeholder="Password">
                            <i class="fa-regular fa-eye eye-icon" id="iconNew" onclick="togglePasswordVisibility()"></i>
                        </div>
                        {{-- <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="colorSizeBtn">
                                {{-- <span class="btn-icon-wrapper pr-2 opacity-7">
                                    <i class="fas fa-sign-in-alt"></i>
                                </span> --}}
                                Entrar
                            </button>
                        </div>
                    </div>
                </form>


                {{-- <p class="social-auth-links text-center mb-3">- ou acesse por sua conta -</p> --}}
                {{-- <div class="row">
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

                    

                </div> --}}
            </div>

        </div>
    </div>

    {{-- <div class="app-page-title">
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
    </div> --}}

    <script src="{{ url(mix('public/dist/js/adminlte.js'))}}"></script>
    <script src="{{ asset('frontend/login/script.js') }}"></script>
    <script>
        function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const hiddeIcon = document.getElementById('iconNew');
    const isPassword = passwordInput.type === 'password';
    
    // Alterna o tipo do input
    passwordInput.type = isPassword ? 'text' : 'password';

    // Alterna a classe do ícone com base no estado do input
    if (isPassword) {
        hiddeIcon.classList.remove('fa-eye');
        hiddeIcon.classList.add('fa-eye-slash');
    } else {
        hiddeIcon.classList.remove('fa-eye-slash');
        hiddeIcon.classList.add('fa-eye');
    }
}


    </script>
</body>
</html>
