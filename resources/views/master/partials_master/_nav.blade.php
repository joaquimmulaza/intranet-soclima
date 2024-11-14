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
            
            
            @if(solicitacoes() > 0)
                <li class="nav-item">
                    <a style="padding: 0 !important; margin: 0 !important;" class="nav-link" href="{{route('user.pedidos')}}"> {{-- Redirecionar para a página de pedidos de férias --}}
                        <span class="badge shapeNotification navbar-badge">
                            {{solicitacoes()}}
                        </span>
                    <img src="{{asset('logo/img/icon/Notification-button.svg')}}" alt="">
                    </a>
                    <div class="dropdown-content" id="notificationDropdown">
                    <h5>Notificações</h5>
                    <hr>
                    <div class="menuOpt">
                        @if(solicitacoes() > 0)
                            <a href="{{route('user.pedidos')}}"><img src="logo/img/icon/notification-icon.svg" alt="">Pedidos de Férias</a>
                        @else
                            <span>Sem novas notificações</span>
                        @endif
                    </div>
                </li>
                @else
                    <li class="nav-item">
                    <a style="padding: 0 !important; margin: 0 !important;" class="nav-link notificacao" data-toggle="dropdown" id="notificationDropdownToggle">
                        <!-- <span class="  navbar-badge">
                            {{solicitacoes()}}
                        </span> -->
                        <img src="{{asset('logo/img/icon/Notification-button.svg')}}" alt="">
                    </a>
                    <div class="dropdown-content" id="notificationDropdown">
                    <h5>Notificações</h5>
                    <hr>
                    <div class="menuOpt">
                        @if(solicitacoes() > 0)
                            <a href="{{route('user.pedidos')}}"><img src="logo/img/icon/notification-icon.svg" alt="">Pedidos de Férias</a>
                        @else
                            <span>Sem novas notificações</span>
                        @endif
                    </div>
                </div>
                </li>
            @endcan
            <li class="nav-item">
                <a style="padding: 0 !important; margin: 0 !important;" class="nav-link myProfile"
                href="#" class="nav-link"><img src="{{asset('logo/img/icon/user-avatar.svg')}}" alt="" id="profileDropdownToggle">
                
            </a>
            <div class="dropdown-content" id="profileDropdown">
                <div class="headerDropdownProfile">
                    <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt="">
                    <div class="content-dropdown-profile">
                        <h3>{{ Auth::user()->name }}</h3>
                        <span>{{ Auth::user()->cargo->titulo }}</span>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#cardUserViewNav-{{ Auth::user()->id }}" class="btn-dropdown-pressed">Meu Perfil</a>
                <hr>
                <div class="menuOpt">
                    <a href="">Configurações e privacidade</a>
                    <a href="">Contas suspensas</a>
                    <a class="{{Route::current()->getName() === 'admin.logout' ? 'active' : ''}}"
                data-toggle="tooltip" title="Sair do sistema" href="{{route('admin.logout')}}" >Sair</a>
                </div>

                <div class="modal fade cardUserView" id="cardUserViewNav-{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">
                                <hr>
                                    <div class="profile d-flex align-items-center mb-3">
                                        <div class="user-info-left">
                                       
                                        <img src="{{ URL::to('/') }}/public/avatar_users/{{ Auth::user()->avatar }}" alt="Foto do perfil" style="border-radius: 50%; width: 60px; height: 60px; margin-right: 15px;">

                                            <div>
                                                <h4 style="padding: 0 !important; margin: 0 !important;">{{ Auth::user()->name }}</h4>
                                                <p  style="padding: 0 !important; margin: 0 !important;">{{ Auth::user()->cargo->titulo}}</p>
                                                <p style="padding: 0 !important; margin: 0 !important;">{{Auth::user()->unidade->titulo}}</p>
                                            </div>
                                        </div>
                                            <div>
                                                <a style="border: none;" href="{{route('user.edit', ['user' => Auth::user()->id])}}">
                                                    <img src="logo/img/icon/icon-edit.svg" alt="">
                                                </a>
                                            </div>
                                       
                                    </div>
                                <hr>
                                    <div class="info-section">
                                        <p>Data de nascimento: <span>{{date('d/m/Y', strtotime(Auth::user()->nascimento))}}</span></p>
                                        <p>Gênero:<span>{{ Auth::user()->genero }}</span></p>
                                        <p>Nº mecanográfico: <span>{{ Auth::user()->numero_mecanografico }}</span></p>
                                        <p>Telefone da firma: <span>{{ Auth::user()->fone }}</span></p>
                                        <p>E-mail: <span>{{ Auth::user()->email }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

                
            </li>
            <span><img src="{{asset('logo/img/icon/line-1.svg')}}" alt=""></span>
            @can('app.dashboard')
            <li class="nav-item btnCadastrar">
                <a class="linksNav {{Route::current()->getName() === 'user.create' || '' ? 'active menu-open' : ''}}" style="padding: 0 !important; margin: 0 !important;" class="nav-link {{Route::current()->getName() === 'admin' ? 'active' : ''}}"
                href="{{route('user.create')}}" class="nav-link colorLink">Cadastrar</a>
            </li>
        
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
                            <a class="{{Route::current()->getName() === 'user.index' ? 'menu-open' : ''}}" href="{{route('user.index')}}"><img src="logo/img/icon/managerUser.svg" alt="">Gerir usuários</a>
                            <a href="#"><img src="logo/img/icon/holiday-icon.svg" alt="">Pedidos férias</a>
                            <a href="#"><img src="logo/img/icon/feeds.svg" alt="">Publicações e atividades</a>
                        </div>

                        <div class="menuOpt">
                            <span>Geral</span>
                            <a href="#"><img src="logo/img/icon/recibos-icon.svg" alt="">Recibos</a>
                            <a href="#"><img src="logo/img/icon/justificativo-icon.svg" alt="">Justificativos</a>
                            <a class="{{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}" href="{{route('telefones.index')}}"><img src="logo/img/icon/list-phone.svg" alt="">Lista telefônica</a>
                            <a href="#"><img src="logo/img/icon/ferias-icon.svg" alt="">Férias</a>
                        </div>
                    </div>
               
            </li>

            {{-- HELPER PARA SOLICITAÇÕES DE PEDIDOS --}}
            @can('app.dashboard')
                
        </div>
            @endif
        @endcan

    </ul>

    

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Função para controlar a exibição de um dropdown específico e fechar os outros abertos
    function toggleDropdown(dropdownId, toggleButtonId) {
        const dropdown = document.getElementById(dropdownId);
        const toggleButton = document.getElementById(toggleButtonId);

        toggleButton.addEventListener('click', function(event) {
            event.preventDefault(); // Previne comportamento padrão
            
            // Fecha outros dropdowns antes de abrir o atual
            closeOtherDropdowns(dropdownId);

            dropdown.classList.toggle('show'); // Alterna a exibição do dropdown
        });

        // Fecha o dropdown ao clicar fora dele
        window.addEventListener('click', function(event) {
            if (!toggleButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    }

    // Função para fechar outros dropdowns
    function closeOtherDropdowns(currentDropdownId) {
        const dropdowns = document.querySelectorAll('.dropdown-content'); // Seleciona todos os dropdowns

        dropdowns.forEach(dropdown => {
            if (dropdown.id !== currentDropdownId) { // Fecha apenas os dropdowns que não são o atual
                dropdown.classList.remove('show');
            }
        });
    }

    // Inicializa os dropdowns
    toggleDropdown('notificationDropdown', 'notificationDropdownToggle');
    toggleDropdown('profileDropdown', 'profileDropdownToggle');
    toggleDropdown('menuDropdown', 'menuDropdownToggle');

    

        $('.cardUserView').on('show.bs.modal', function () {
            $('body').addClass('modal-open-no-backdrop');
        });

        $('.cardUserView').on('hidden.bs.modal', function () {
            // Não remove a classe modal-open-no-backdrop, portanto, o fundo semitransparente não será restaurado
        });

        $(document).on('click', function (event) {
            const $modal = $('.cardUserView');
            if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
                $modal.modal('hide');
            }
        });
</script>
