<style>
    
</style>

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
                <h5>Meu Perfil</h5>
                <hr>
                <div class="menuOpt">
                    <a href="">Ver Perfil</a>
                    <a href="">Configurações</a>
                    <a href="">Sair</a>
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


<script>
   

    // Função para controlar a exibição de um dropdown específico
    function toggleDropdown(dropdownId, toggleButtonId) {
        const dropdown = document.getElementById(dropdownId);
        const toggleButton = document.getElementById(toggleButtonId);

        toggleButton.addEventListener('click', function(event) {
            event.preventDefault(); // Previne comportamento padrão
            dropdown.classList.toggle('show'); // Alterna a exibição do dropdown
        });

        // Fecha o dropdown ao clicar fora dele
        window.addEventListener('click', function(event) {
            if (!toggleButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
    }

    // Inicializa os dropdowns
    toggleDropdown('notificationDropdown', 'notificationDropdownToggle');
    toggleDropdown('profileDropdown', 'profileDropdownToggle');
    toggleDropdown('menuDropdown', 'menuDropdownToggle');
</script>