<nav class="main-header navbar navbar-expand navbar-white heightNav justify-content-start" style="margin: 0 !important;">

    <!-- MENU ESQUERDO ADMINISTRATIVO -->
    <ul class="navbar-nav widthNav">
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"
               role="button"
               data-toggle="collapse"
               data-targ et="#suporteContent"
               aria-controls="suporteContent"
               aria-expanded="false"
               aria-label="Toggle navigation">

                <i class="fas fa-bars"></i>
            </a>
        </li> -->
        <div class="contentRight">
            {{-- CLASSES QUE SOME ITEM DA LISTA EM TAMANHO SM: d-none d-sm-inline-block--}}
            <li class="nav-item">
                <a  class="nav-link {{Route::current()->getName() === 'home' ? 'active' : ''}}"
                href="{{route('home')}}"><img style="position: relative; bottom: 10px;" src="logo/img/200x70.svg" alt=""></a>
            </li>
            <li class="nav-item">
                <input class="nav-link backgroundInput" placeholder="Pesquisar" type="text">
            </li>
        </div>
        <div class="contentLeft">
            <li class="nav-item">
                <a style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'home' ? 'active' : ''}}"
                href="{{route('home')}}"><img src="logo/img/icon/home-button-pressed.svg" alt=""></a>
            </li>
            
            
            @if(solicitacoes() > 0)
                <li class="nav-item">
                    <a style="padding: 0 !important; margin: 0 !important;" class="nav-link" href="{{route('user.pedidos')}}"> {{-- Redirecionar para a página de pedidos de férias --}}
                        <span class="badge badge-warning navbar-badge">
                            {{solicitacoes()}}
                        </span>
                    <img src="logo/img/icon/Notification-button.svg" alt="">
                    </a>
                </li>
                @else
                    <li class="nav-item">
                    <a style="padding: 0 !important; margin: 0 !important;" class="nav-link" data-toggle="dropdown">
                        <span class="badge badge-success navbar-badge">
                            {{solicitacoes()}}
                        </span>
                        <img src="logo/img/icon/Notification-button.svg" alt="">
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a style="padding: 0 !important; margin: 0 !important;" class="nav-link"
                href="#" class="nav-link"><img src="logo/img/icon/user-avatar.svg" alt=""></a>
            </li>
            <span><img src="logo/img/icon/line-1.svg" alt=""></span>
            @can('app.dashboard')
            <li class="nav-item btnCadastrar">
                <a class="linksNav {{Route::current()->getName() === 'user.create' || '' ? 'active menu-open' : ''}}" style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'admin' ? 'active' : ''}}"
                href="{{route('user.create')}}" class="nav-link colorLink">Cadastrar</a>
            </li>
        
            <li class="nav-item">
                <a style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'admin.logout' ? 'active' : ''}}"
                data-toggle="tooltip" title="Sair do sistema" href="{{route('admin.logout')}}" class="nav-link">
                <img src="logo/img/icon/Menu.svg" alt=""></a>
            </li>

            {{-- HELPER PARA SOLICITAÇÕES DE PEDIDOS --}}
            @can('app.dashboard')
                
        </div>
            @endif
        @endcan

    </ul>

</nav>