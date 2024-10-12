@include('public.partials._headLogin')
<title>Logar no sistema</title>

<body id="intro-login" class="hold-transition login-page">
<div class="bg-image"></div>
<div class="login-box">
    <!-- LOGO -->
    <div class="login-logo">
        <img src="{{asset('logo/img/logo250x62.png')}}" alt="Logo" style="opacity: .8">
    </div>

    <!-- PEDIDO CONCLUIDO -->
    <div class="view text-center pt-5 w-auto">
        <div class="container-fluid">
            <div class="text-success mt-2 mb-4 titulo">Pedido realizado com sucesso!!</div>
            <hr class="hr-light">
            <div class="subtext-header mt-2 mb-4">Seu pedido esta em analise...  Você receberá um retorno em sua conta de email. Obrigado!</div>
        </div>
        <a href="{{ route('admin.login') }}" class="btn btn-rounded btn-outline-deep-purple">
                  <span class="btn-icon-wrapper pr-2 opacity-7">
                      <i class="fas fa-arrow-circle-left fa-w-30"></i>
                  </span>
            Voltar
        </a>
    </div>
</div>

<script src="{{ url(mix('public/dist/js/adminlte.js'))}}"></script>

</body>
</html>
