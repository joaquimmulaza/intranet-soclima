@include('public.partials._headLogin')
<title>Registro de usuário</title>

<body id="intro-login" class="hold-transition login-page">
    <div class="bg-image"></div>
    <div class="login-box">
        <div class="login-logo">
          <img src="{{asset('logo/img/logo250x62.png')}}" alt="Logo" style="opacity: .8">
        </div>

        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">{{ $msg }}</p>

            <form action="{{route('user.novo')}}" method="post">
                @csrf
                @include('public.partials._errors')

                <div class="input-group mb-4 {{ $errors->has('name') ? 'has-error' : '' }}">
                  <input id="name" name="name" value="{{ Request::old('name')}}" type="text" class="form-control" placeholder="Informe seu nome completo"/>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>

                <div class="input-group mb-4 {{ $errors->has('email') ? 'has-error' : '' }}">
                  <input id="email" name="email" value="{{ Request::old('email')}}" type="email" class="form-control" placeholder="Informe seu email"/>
                  <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                      <button type="submit" class="btn-shadow btn btn-md btn-deep-purple btn-block">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                          Solicitar acesso
                      </button>
                      <button type="reset" class="btn-shadow btn btn-md btn-block btn-danger mt-2">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-eraser fa-w-20"></i>
                        </span>
                          Limpar
                      </button>
                  </div>
                </div>


            </form>

          </div>
        </div>
    </div>

    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-actions">
          <div class="d-inline-block dropdown">
            <a href="{{ route('admin.login') }}" class="btn-shadow btn btn-md teal lighten-2 rounded">
                  <span class="btn-icon-wrapper pr-2 opacity-7">
                      <i class="fas fa-arrow-circle-left fa-w-20"></i>
                  </span>
              Voltar para login
            </a>
          </div>
        </div>
      </div>
    </div>
@include('vendor.lara-izitoast.toast')
<!-- jQuery -->
<script src="{{ url(mix('public/plugins/jquery/jquery.min.js'))}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url(mix('public/plugins/bootstrap/js/bootstrap.bundle.min.js'))}}"></script>
<!-- AdminLTE App -->
<script src="{{ url(mix('public/dist/js/adminlte.js'))}}"></script>

<script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
<script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>

</body>
</html>
