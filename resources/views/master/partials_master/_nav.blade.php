<nav class="main-header navbar navbar-expand navbar-dark justify-content-start">

    <!-- MENU ESQUERDO ADMINISTRATIVO -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"
               role="button"
               data-toggle="collapse"
               data-target="#suporteContent"
               aria-controls="suporteContent"
               aria-expanded="false"
               aria-label="Toggle navigation">

                <i class="fas fa-bars"></i>
            </a>
        </li>

        {{-- CLASSES QUE SOME ITEM DA LISTA EM TAMANHO SM: d-none d-sm-inline-block--}}
        <li class="nav-item">
            <a class="nav-link {{Route::current()->getName() === 'home' ? 'active' : ''}}"
               href="{{route('home')}}">Home</a>
        </li>
        @can('app.dashboard')
            <li class="nav-item">
                <a class="nav-link {{Route::current()->getName() === 'admin' ? 'active' : ''}}"
                   href="{{route('admin')}}" class="nav-link">Dashboard</a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link {{Route::current()->getName() === 'admin.logout' ? 'active' : ''}}"
               data-toggle="tooltip" title="Sair do sistema" href="{{route('admin.logout')}}" class="nav-link">
                <i class="fas fa-sign-out-alt fa-lg" style="width: 1.25em; font-weight: 600; font-size: 20px; text-align: center;"></i></a>
        </li>

        {{-- HELPER PARA SOLICITAÇÕES DE PEDIDOS--}}
        @can('app.dashboard')
            @if(solicitacoes() > 0)
            <li class="nav-item">
                <a class="nav-link" href="{{route('user.pedidos')}}">
                    <span class="badge badge-warning navbar-badge">
                        {{solicitacoes()}}
                    </span>
                  <i class="fas fa-bell" style="font-size: 22px; color: white;"></i>
                </a>
            </li>
            @else
                <li class="nav-item">
                <a class="nav-link" data-toggle="dropdown">
                    <span class="badge badge-success navbar-badge">
                        {{solicitacoes()}}
                    </span>
                    <i class="far fa-bell" style="font-size: 22px;"></i>
                </a>
            </li>
            @endif
        @endcan
    </ul>

</nav>