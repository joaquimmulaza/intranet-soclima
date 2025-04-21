<nav class="main-header navbar navbar-expand navbar-white heightNav justify-content-start" style="margin: 0 !important;">
    <!-- MENU ESQUERDO ADMINISTRATIVO -->
    <ul class="navbar-nav widthNav">
        <div class="contentRight">
            {{-- CLASSES QUE SOME ITEM DA LISTA EM TAMANHO SM: d-none d-sm-inline-block--}}
            <li class="nav-item">
                <a  class="nav-link {{Route::current()->getName() === 'home' ? 'active' : ''}}"
                href="{{route('home')}}"><img style="position: relative; bottom: 10px;" src="{{asset('logo/img/200x70.svg')}}" alt=""></a>
            </li>
            <li class="nav-item">
                <input style="position relative; left: 6.5px;" class="nav-link backgroundInput" placeholder="Pesquisar" type="text">
            </li>
        </div>
        <div class="contentLeft">
            <li class="nav-item">
            <a style="padding: 0 !important; margin: 0 !important;" 
       class="nav-link {{ Route::current()->getName() === 'home' ? 'active' : '' }}" 
       href="{{ route('home') }}">
        <img src="{{ Route::current()->getName() === 'home' ? asset('logo/img/icon/home-button-pressed.svg') : asset('logo/img/icon/home-button-normal.svg') }}" 
             alt="Home Icon">
                </a>
            </li>
            <span><img src="{{asset('logo/img/icon/line-1.svg')}}" alt=""></span>
                @can('app.dashboard')
                <li class="nav-item btnCadastrar">
                    <a class="linksNav {{Route::current()->getName() === 'user.create' || '' ? 'active menu-open' : ''}}" style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'admin' ? 'active' : ''}}"
                    href="{{route('user.create')}}" class="nav-link colorLink">Cadastrar</a>
                </li>
                
                @endif
                <li class="nav-item menu">
                    <a id="menuDropdownToggle" style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'admin.logout' ? 'active' : ''}}"
                    data-toggle="tooltip" title="Sair do sistema" href="#">
                        <img src="{{asset('logo/img/icon/Menu.svg')}}" alt="">
                    </a>
                        <!-- Dropdown Content -->
                        <div class="dropdown-content" id="menuDropdown">
                            <h5>Menu</h5>
                            <hr>
                            <div class="menuOpt">
                                <a href="#"><img src="logo/img/icon/calendar-star.svg" alt="">Eventos</a>
                                <span>Gerenciar</span>
                                @can('app.dashboard')
                                <a class="{{Route::current()->getName() === 'user.index' ? 'menu-open' : ''}}" href="{{route('user.index')}}">
                            
                                    <img src="logo/img/icon/managerUser.svg" alt="">Gerir usuários</a>
                                    @endcan
                                <a href="{{route('ferias.pedidos')}}"><img src="logo/img/icon/holiday-icon.svg" alt="">Pedidos férias</a>
                                <a href="#"><img src="logo/img/icon/feeds.svg" alt="">Publicações e atividades</a>
                            </div>

                            <div class="menuOpt">
                                <span>Geral</span>
                                <a href="#"><img src="logo/img/icon/recibos-icon.svg" alt="">Recibos</a>
                                @can('app.dashboard')
                                <a href="{{route('documents.show')}}"><img src="logo/img/icon/justificativo-icon.svg" alt="">Justificativos</a>
                                @endcan
                                <a class="{{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}" href="{{route('telefones.index')}}"><img src="logo/img/icon/list-phone.svg" alt="">Lista telefônica</a>
                                
                                <a href="{{route('documents.show')}}"><img src="logo/img/icon/ferias-icon.svg" alt="">Ausências</a>
                                @can('app.dashboard')
                                <a href="{{route('admin_docs.index')}}"><img src="{{asset('logo/img/icon/text_snippet.svg')}}" alt="">Documentos Solicitados</a>
                                @endcan
                            </div>
                        </div>
                </li>

            {{-- HELPER PARA SOLICITAÇÕES DE PEDIDOS --}}
           
                
        </div>
           

    </ul>

    

</nav>