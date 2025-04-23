@extends('master.layout')
@section('title', 'Listagem de usuários')



@section('content')
    {{-- CABEÇALHO BREADCRUMB--}}
    <div class="content-header header-crumb">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item active"><a href="{{route('home')}}">Home</a></li> -->
                        <li class="breadcrumb-item active">Gestão de usuários</li>
                    </ol>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <section class="content" style="display: none;">
        <div class="container-fluid">
            

            <div class="row containerPrincipal">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 containerPrincipal">
                    <div class="main-card mb-3 card card-primary">
                        <div class="table-responsive">
                             <table id="datatable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Nome</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Dias de Férias</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if(Cache::has('is_online' . $user->id))
                                                    <img class="online" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                                                @else
                                                    <img class="offline" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="widget-content-left flex2">
                                                    <a class="btnList" href="{{ route('user.show', ['user' => $user->id]) }}">
                                                        <div class="widget-heading">{{ $user->name }}</div>
                                                    </a>
                                                    <div class="widget-subheading opacity-7">
                                                        @if ($user->role)
                                                            <span class="badge badge-info">{{ $user->role->name }}</span>
                                                        @else
                                                            <span class="badge badge-danger">No role found :(</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{{$user->email}}</div>

                                                    @if(Cache::has('is_online' . $user->id))
                                                        <span class="badge badge-success">Online</span>
                                                    @else
                                                        <span class="badge badge-warning">Offline</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                {{ $user->diasFerias->dias_disponiveis ?? 0 }} dias
                                            </td>

                                            <td class="text-center">
                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white"
                                                       href="{{route('users.ferias', ['userId' => $user->id])}}">
                                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-edit fa-w-20"></i>
                                                       </span>
                                                        Atualizar Férias
                                                    </a>
                                                @endcan

                                                @can('app.roles.edit')
                                                    <a type="button" class="btn btn-md btn-success rounded text-white"
                                                       href="{{route('user.edit', ['user' => $user->id])}}">
                                                       <span class="btn-icon-wrapper pr-2 opacity-7">
                                                            <i class="fas fa-edit fa-w-20"></i>
                                                       </span>
                                                        Editar
                                                    </a>
                                                @endcan

                                                @can('app.roles.destroy')
                                                    <button type="button" class="btn btn-md btn-danger rounded" onClick="deleteDataUser({{ $user->id }})">
                                                           <span class="btn-icon-wrapper pr-2 opacity-9">
                                                                <i class="fas fa-trash-alt fa-w-20"></i>
                                                           </span>
                                                        Deletar
                                                    </button>
                                                    <form id="delete-user-form-{{ $user->id  }}"
                                                          action="{{route('user.destroy', ['user'=>$user->id])}}" method="POST" style="display: none;">
                                                        @csrf()
                                                        @method('DELETE')
                                                    </form>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                               </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="footer">
                        <a type="button" class="btn btn-md btn-outline-danger waves-effect" href="{{ route('pdf.users') }}" target="_blank">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-pdf fa-w-20"></i>
                            </span>
                            Baixar PDF
                        </a>
                        <a type="button" class="btn btn-md btn-outline-success waves-effect" href="{{ route('excel.users') }}">
                            <span class="btn-icon-wrapper pr-2 opacity-3">
                                <i class="far fa-file-excel fa-w-20"></i>
                            </span>
                            Baixar Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="user-management">
            <div class="search-bar">
                <input class="nav-link backgroundInput" id="pesquisarNome" placeholder="Pesquisar" type="text">
                <button class="btnFiltrarUser" id="filterButton">
                    <img src="logo/img/icon/filter.svg" alt="">
                </button>
                <div id="filterTooltip" class="filter-tooltip" style="display: none;">
                    <div class="header_tootipFilter">
                        <h3>Departamentos</h3>
                        <hr>
                    </div>
                    <ul id="unidadesList">
                       
                    
                        <!-- As unidades serão preenchidas dinamicamente via JavaScript -->
                    </ul>
                </div>
            </div>
            <div class="user-grid">
                @foreach($users as $user)
                    <div class="user-card "  data-name="{{ strtolower($user->name) }}">
                    @if(Cache::has('is_online' . $user->id))
                        <img class="online " src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                    @else
                        <img class="offline" src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}">
                    @endif
                        <div class="user-info">
                            <h3>{{ $user->name }}</h3>
                            <p style="padding: 0 !important; margin: 0 !important;">{{ $user->cargo->titulo}} | {{$user->unidade->titulo}}</p>
                        </div>
                        <a class="edit-btn" href="{{route('user.edit', ['user' => $user->id])}}">Editar</a>
                        <div class="containerOpt" style="">
                            <button class="btnOpt"  data-toggle="modal" data-target="#modalOpt-{{ $user->id }}" style="margin: 0 !important; padding: 0 !important;">⋮</button>
                            <div class="modal fade modalOpt modalOptUsers" id="modalOpt-{{ $user->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt ">
                                        @can('app.dashboard')
                                            <button style="border-top-left-radius: 5px; border-top-right-radius: 5px;" type="button" class="btnPosts" onClick="deleteData({{ $user->id }})">
                                                Eliminar
                                            </button>
                                            <button type="button" 
                                                    class="btnPosts" 
                                                    data-toggle="modal" 
                                                    data-target="#modalEdit"
                                                    data-id="{{ $user->id }}"
                                                    data-status="{{ $user->status }}"
                                                    onclick="toggleStatus(this)">
                                                {{ $user->status == 'ativo' ? 'Suspender' : 'Ativar' }}
                                            </button>

                                            
                                            <a href="{{ route('ferias.show', ['id' => $user->id]) }}" data-target="#modalEdit" style="border-bottom: none;" class="btnPosts button_a"  data-id="{{$user->id}}" data-title="{{$user->title}}" data-content="{{$user->content}}">
                                                Consultar férias
                                            </a>
                                            <button style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" type="button" data-toggle="modal" data-target="#cardUserView-{{ $user->id }}" class="btnPosts">
                                                Ver dados
                                            </button>
                                            <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST" style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade cardUserView escurecer" id="cardUserView-{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-dismiss="modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-header-center">
                                        <img src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}" alt="Foto do perfil">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true"><img src="logo/img/icon/clear.svg" alt=""></span>
                                    </button>
                                </div>
                               
                                <div class="modal-body">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <div class="user-info-left">
                                            
                                            <div>
                                                <h4 style="padding: 0 !important; margin: 0 !important;">{{ $user->name }}</h4>
                                                <p  style="padding: 0 !important; margin: 0 !important;">{{ $user->cargo->titulo}}</p>
                                            </div>
                                        </div>
                                        <div class="divBtnEdit">
                                            <a href="{{route('user.edit', ['user' => $user->id])}}">
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
                                                <img class="size-g-icon" src="logo/img/icon/cake.svg" alt="">
                                                <span class="">Data de nascimento:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime($user->nascimento))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/gender.svg" alt="">
                                                <span>Gênero:</span>
                                            </div>
                                            <span>{{ $user->genero }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/eventIcon.svg" alt="">
                                                <span>Data de admissão:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime($user->data_admissao))}}</span>
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
                                            <span>{{ $user->fone }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/mail.svg" alt="">
                                                <span>E-mail</span>
                                            </div>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="logo/img/icon/numbers.svg" alt="">
                                                <span class="">Nº mecanográfico:</span>
                                            </div>
                                            <span>{{ $user->numero_mecanografico }}</span>
                                        </div>
                                        <div class="dadosPessoais" style="display: none;">
                                            <div>
                                                <button class="btn-link" data-toggle="modal" data-target="#outrosDadosModal-{{ $user->id }}" data-dismiss="modal">Outros dados</button>
                                            </div>
                                            <span><img src="logo/img/icon/chevron_right.svg" alt=""></span>
                                        </div>
                                        <div class="modal fade" id="outrosDadosModal-{{ $user->id }}" tabindex="-1" aria-labelledby="outrosDadosLabel" aria-hidden="true" data-parent-modal="cardUserView-{{ $user->id }}">
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
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cardUserView-{{ $user->id }}" data-dismiss="modal">
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
                    
                    
                @endforeach
            </div>
        </div>

        
        
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $('.modalOptUsers').on('show.bs.modal', function () {
            $('body').addClass('modal-open-no-backdrop');
        });

        $('.modalOptUsers').on('hidden.bs.modal', function () {
            // Não remove a classe modal-open-no-backdrop, portanto, o fundo semitransparente não será restaurado
        });

        $(document).on('click', function (event) {
            const $modal = $('.modalOptUsers');
            if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
                $modal.modal('hide');
            }
        });

        // $(document).on('hidden.bs.modal', function (e) {
        //     if ($('.modal.show').length) {
        //         $('body').addClass('modal-open');
        //     }
        // });


        function toggleStatus(button) {
    // Obtém o ID do usuário e o status atual
    var userId = $(button).data('id');
    var currentStatus = $(button).data('status');
    
    // Envia a requisição AJAX para a rota de ativação/desativação
    $.ajax({
        url: '/user/' + userId + '/ativar',  // Altere conforme sua rota
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',  // Adiciona o token CSRF para a segurança
        },
        success: function(response) {
            // Se a requisição for bem-sucedida, atualiza o status
            if (response.status === 'ativo') {
                $(button).text('Suspender');  // Altera o texto para 'Suspender'
                $(button).data('status', 'ativo');  // Atualiza o status do botão
            } else {
                $(button).text('Ativar');  // Altera o texto para 'Ativar'
                $(button).data('status', 'inativo');  // Atualiza o status do botão
            }
            // Exibe uma notificação de sucesso
            alert(response.message);
        },
        error: function(xhr) {
            // Caso haja erro na requisição
            alert('Erro ao atualizar o status do usuário.');
        }
    });
}

function deleteData(userId) {
    var form = document.getElementById('delete-form-' + userId);
    if (confirm("Tem certeza que deseja eliminar este usuário?")) {
        form.submit();  // Envia o formulário
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.getElementById('filterButton');
    const filterTooltip = document.getElementById('filterTooltip');
    const unidadesList = document.getElementById('unidadesList');
    const userGrid = document.querySelector('.user-grid');
    let initialUserGridHtml = userGrid.innerHTML; // Armazenar o HTML inicial
    

    // Função para alternar o tooltip
    filterButton.addEventListener('click', function (e) {
        e.preventDefault();
        filterTooltip.style.display = filterTooltip.style.display === 'none' ? 'block' : 'none';

        // Carregar departamentos ao abrir o tooltip (apenas se ainda não foram carregados)
        if (unidadesList.children.length === 0) {
            fetchDepartamentos();
        }
    });

    // Fechar o tooltip se clicar fora dele
    document.addEventListener('click', function (e) {
        if (!filterButton.contains(e.target) && !filterTooltip.contains(e.target)) {
            filterTooltip.style.display = 'none';
        }
    });

    // Função para buscar departamentos via AJAX
    function fetchDepartamentos() {
        fetch('/departamentos', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('Erro retornado pelo servidor:', data.error);
                    return;
                }
                unidadesList.innerHTML = '';
                // Adicionar opção "Todos"
                const todosLi = document.createElement('li');
                todosLi.textContent = 'Todos';
                todosLi.dataset.departamentoId = 'todos';
                todosLi.addEventListener('click', () => filterUsersByDepartamento('todos'));
                unidadesList.appendChild(todosLi);
                // Adicionar departamentos
                data.unidades.forEach(unidade => {
                    const li = document.createElement('li');
                    li.textContent = unidade.titulo;
                    li.dataset.departamentoId = unidade.id;
                    li.addEventListener('click', () => filterUsersByDepartamento(unidade.id));
                    unidadesList.appendChild(li);
                });
            })
            .catch(error => console.error('Erro ao carregar departamentos:', error));
    }

    // Função para filtrar usuários por departamento
    function filterUsersByDepartamento(departamentoId) {
        if (departamentoId === 'todos') {
            // Restaurar o HTML inicial da grade
            userGrid.innerHTML = initialUserGridHtml;
            filterTooltip.style.display = 'none';
            return;
        }

        fetch(`/users/filter-by-departamento/${departamentoId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('Erro retornado pelo servidor:', data.error);
                    return;
                }
                updateUserGrid(data.users);
                filterTooltip.style.display = 'none';
            })
            .catch(error => console.error('Erro ao filtrar usuários:', error));
    }

    // Função para atualizar a grade de usuários
    function updateUserGrid(users) {
        userGrid.innerHTML = ''; // Limpar a grade atual

        users.forEach(user => {
            // Função auxiliar para formatar datas no formato dd/mm/yyyy
            const formatDate = (date) => {
                if (!date) return '';
                const d = new Date(date);
                return `${d.getDate().toString().padStart(2, '0')}/${(d.getMonth() + 1).toString().padStart(2, '0')}/${d.getFullYear()}`;
            };

            const userCard = `
                <div class="user-card">
                    <img class="${user.is_online ? 'online' : 'offline'}" src="/public/avatar_users/${user.avatar}">
                    <div class="user-info">
                        <h3>${user.name}</h3>
                        <p style="padding: 0 !important; margin: 0 !important;">${user.cargo.titulo} | ${user.unidade.titulo}</p>
                    </div>
                    <a class="edit-btn" href="/usuarios/${user.id}/editar">Editar</a>
                    <div class="containerOpt">
                        <button class="btnOpt" data-toggle="modal" data-target="#modalOpt-${user.id}" style="margin: 0 !important; padding: 0 !important;">⋮</button>
                        <div class="modal fade modalOpt modalOptUsers" id="modalOpt-${user.id}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt">
                                            <button style="border-top-left-radius: 5px; border-top-right-radius: 5px;" type="button" class="btnPosts" onclick="deleteData(${user.id})">
                                                Eliminar
                                            </button>
                                            <button type="button" class="btnPosts" data-toggle="modal" data-target="#modalEdit" data-id="${user.id}" data-status="${user.status}" onclick="toggleStatus(this)">
                                                ${user.status === 'ativo' ? 'Suspender' : 'Ativar'}
                                            </button>
                                            <a href="/ferias/${user.id}" style="border-bottom: none;" class="btnPosts button_a" data-id="${user.id}">
                                                Consultar férias
                                            </a>
                                            <button style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" type="button" data-toggle="modal" data-target="#cardUserView-${user.id}" class="btnPosts">
                                                Ver dados
                                            </button>
                                            <form id="delete-form-${user.id}" action="/user/${user.id}" method="POST" style="display: none;">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Modal de Visualização (cardUserView) -->
                    <div class="modal fade cardUserView escurecer" id="cardUserView-${user.id}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-dismiss="modal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-header-center">
                                        <img src="/public/avatar_users/${user.avatar}" alt="Foto do perfil">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true"><img src="/logo/img/icon/clear.svg" alt=""></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="profile d-flex align-items-center mb-3">
                                        <div class="user-info-left">
                                            <div>
                                                <h4 style="padding: 0 !important; margin: 0 !important;">${user.name}</h4>
                                                <p style="padding: 0 !important; margin: 0 !important;">${user.cargo.titulo}</p>
                                            </div>
                                        </div>
                                        <div class="divBtnEdit">
                                            <a href="/usuarios/${user.id}/editar">
                                                <img src="/logo/img/icon/icon-edit.svg" alt="">
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
                                                <img class="size-g-icon" src="/logo/img/icon/cake.svg" alt="">
                                                <span>Data de nascimento:</span>
                                            </div>
                                            <span>${formatDate(user.nascimento)}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/gender.svg" alt="">
                                                <span>Gênero:</span>
                                            </div>
                                            <span>${user.genero || ''}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/eventIcon.svg" alt="">
                                                <span>Data de admissão:</span>
                                            </div>
                                            <span>${formatDate(user.data_admissao)}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/call.svg" alt="">
                                                <span>Telemóvel da firma</span>
                                            </div>
                                            <span></span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/call.svg" alt="">
                                                <span>Telemóvel pessoal:</span>
                                            </div>
                                            <span>${user.fone || ''}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/mail.svg" alt="">
                                                <span>E-mail</span>
                                            </div>
                                            <span>${user.email || ''}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="/logo/img/icon/numbers.svg" alt="">
                                                <span>Nº mecanográfico:</span>
                                            </div>
                                            <span>${user.numero_mecanografico || ''}</span>
                                        </div>
                                        <div class="dadosPessoais" style="display: none;">
                                            <div>
                                                <button class="btn-link" data-toggle="modal" data-target="#outrosDadosModal-${user.id}" data-dismiss="modal">Outros dados</button>
                                            </div>
                                            <span><img src="/logo/img/icon/chevron_right.svg" alt=""></span>
                                        </div>
                                        <div class="modal fade" id="outrosDadosModal-${user.id}" tabindex="-1" aria-labelledby="outrosDadosLabel" aria-hidden="true" data-parent-modal="cardUserView-${user.id}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Outros Dados</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Informações adicionais do usuário aqui.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#cardUserView-${user.id}" data-dismiss="modal">
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
            </div>`;
            userGrid.insertAdjacentHTML('beforeend', userCard);
        });

        // Reinicializar modais do Bootstrap
        document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.dataset.target;
                const modalElement = document.querySelector(modalId);
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } else {
                    console.error(`Modal com ID ${modalId} não encontrado.`);
                }
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("pesquisarNome");
    const userCards = document.querySelectorAll(".user-card");

    // Armazena o valor original de display de cada card
    userCards.forEach(card => {
        card.dataset.originalDisplay = getComputedStyle(card).display;
    });

    input.addEventListener("input", function () {
        const searchTerm = input.value.toLowerCase();

        userCards.forEach(card => {
            const userName = card.querySelector(".user-info h3").textContent.toLowerCase();

            if (userName.includes(searchTerm)) {
                card.style.display = card.dataset.originalDisplay;
            } else {
                card.style.display = "none";
            }
        });
    });
});

    </script>

    <script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
    
@endsection
