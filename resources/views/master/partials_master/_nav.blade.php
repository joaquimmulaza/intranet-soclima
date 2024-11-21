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
            
            
            <li class="nav-item">
    <a style="padding: 0 !important; margin: 0 !important;" class="nav-link notificacao" data-toggle="dropdown" id="notificationDropdownToggle">
        <!-- Shape de notificação -->
        @php
            // Filtrar as notificações para o usuário logado ou responsável
            $userNotifications = $notificacoes->filter(function($notification_user) {
                return $notification_user->user_id == Auth::id() || $notification_user->responsavel_id == Auth::id();
            });
        @endphp

        @if(auth()->check() && $userNotifications->count() > 0)
            <span class="shapeNotification navbar-badge">
                {{ $userNotifications->count() }}
            </span>
        @endif
        <img src="{{ asset('logo/img/icon/Notification-button.svg') }}" alt="Ícone Notificação" id="notificationIcon"
         data-default-icon="{{ asset('logo/img/icon/Notification-button.svg') }}"
        data-pressed-icon="{{ asset('logo/img/icon/Notification-button-pressed.svg') }}"
        >
    </a>
    <div class="dropdown-content" id="notificationDropdown">
        <h5>Notificações</h5>
        <hr>
        <div class="menuOpt">
            <h6>Não lidas</h6>
            @if($userNotifications->count() > 0)
                @foreach($userNotifications as $notification_user)
                    <a class="text-notification" href="{{ $notification_user->rota ?? '#' }}" 
                    onclick="markAsRead('{{ $notification_user->id }}')">
                        <img class="img-notification" src="{{ URL::to('/') }}/public/avatar_users/{{ $notification_user->user->avatar ?? 'default.png' }}" alt="Ícone Notificação">
                        <p style="padding: 0 !important; margin: 0 !important;">{{ $notification_user->descricao }}</p>
                        <small>{{ $notification_user->tempo_decorrido_formatado }}</small>
                    </a>
                @endforeach
            @else
                <span>Sem novas notificações</span>
            @endif
        </div>
    </div>
</li>



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

                <div class="modal fade cardUserView" id="" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
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

            <div class="modal fade cardUserView escurecer" id="cardUserViewNav-{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-dismiss="modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-header-center">
                                        <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" alt="Foto do perfil">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true"><img src="logo/img/icon/clear.svg" alt=""></span>
                                    </button>
                                </div>
                               
                                <div class="modal-body">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <div class="user-info-left">
                                            
                                            <div>
                                                <h4 style="padding: 0 !important; margin: 0 !important;">{{ Auth::user()->name }}</h4>
                                                <p  style="padding: 0 !important; margin: 0 !important;">{{ Auth::user()->cargo->titulo}}</p>
                                                
                                            </div>
                                        </div>
                                        <div class="divBtnEdit">
                                            <a href="{{ route('user.edit', ['user' => Auth::user()->id]) }}">
                                                <img src="logo/img/icon/icon-edit.svg" alt="">
                                            </a>
                                        </div>
                                       
                                    </div>
                                    <hr style="width: 537px; position: absolute; left: 0; right: 0; background-color: #cecece !important;">

                                    <div class="btnCardUser">
                                        <button>Dados deste perfil</button>
                                        <button>Publicações</button>
                                    </div>
                                    <div class="info-section">
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon"{{ asset('logo/img/icon/cake.svg') }}" alt="">
                                                <span class="">Data de nascimento:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime(Auth::user()->nascimento))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/gender.svg" alt="">
                                                <span>Gênero:</span>
                                            </div>
                                            <span>{{ Auth::user()->genero }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/eventIcon.svg" alt="">
                                                <span>Data de admissão:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime(Auth::user()->data_admissao))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/call.svg" alt="">
                                                <span>Telemóvel da firma</span>
                                            </div>
                                            <span></span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/call.svg" alt="">
                                                <span>Telemóvel pessoal:</span>
                                            </div>
                                            <span>{{ Auth::user()->fone }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/mail.svg" alt="">
                                                <span>E-mail</span>
                                            </div>
                                            <span>{{ Auth::user()->email }}</span>
                                        </div>
                                        
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/numbers.svg" alt="">
                                                <span class="">Nº mecanográfico:</span>
                                            </div>
                                            <span>{{ Auth::user()->numero_mecanografico }}</span>
                                        </div>
                                        <div class="dadosPessoais" style="display: none;">
                                            <div>
                                                <button class="btn-link" data-toggle="modal" data-target="#outrosDadosModal-{{ Auth::user()->id }}" data-dismiss="modal">Outros dados</button>
                                            </div>
                                            <span><img src="logo/img/icon/chevron_right.svg" alt=""></span>
                                        </div>
                                        <div class="modal fade" id="outrosDadosModal-{{ Auth::user()->id }}" tabindex="-1" aria-labelledby="outrosDadosLabel" aria-hidden="true" data-parent-modal="cardUserView-{{ Auth::user()->id }}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Outros Dados</h5>
                                                        <button type="button" class="close" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Conteúdo do Modal -->
                                                        <p>Informações adicionais do usuário aqui.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cardUserView-{{ Auth::user()->id }}" data-dismiss="modal">
                                                            Voltar
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                            Fechar Todos
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
           
                
        </div>
           

    </ul>

    

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Função para controlar a exibição de um dropdown específico e fechar os outros abertos// Função para controlar a exibição de um dropdown específico e fechar os outros abertos
function toggleDropdown(dropdownId, toggleButtonId) {
    const dropdown = document.getElementById(dropdownId);
    const toggleButton = document.getElementById(toggleButtonId);

    toggleButton.addEventListener('click', function (event) {
        event.preventDefault();

        // Fecha outros dropdowns antes de abrir o atual
        closeOtherDropdowns(dropdownId);

        dropdown.classList.toggle('show'); // Alterna a exibição do dropdown
        updateNotificationIcon(); // Atualiza o ícone de notificação
    });

    // Fecha o dropdown ao clicar fora dele
    window.addEventListener('click', function (event) {
        if (!toggleButton.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
            updateNotificationIcon(); // Restaura o ícone de notificação
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

// Função específica para alternar o ícone de notificação
function updateNotificationIcon() {
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationIcon = document.getElementById('notificationIcon');

    // Obter os caminhos do ícone dos atributos data
    const defaultIconPath = notificationIcon.dataset.defaultIcon;
    const pressedIconPath = notificationIcon.dataset.pressedIcon;

    // Alterar o ícone com base no estado do dropdown
    if (notificationDropdown.classList.contains('show')) {
        notificationIcon.src = pressedIconPath; // Ícone pressionado
    } else {
        notificationIcon.src = defaultIconPath; // Ícone padrão
    }
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
