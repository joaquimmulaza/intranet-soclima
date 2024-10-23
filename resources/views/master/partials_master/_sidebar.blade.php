<aside class="main-sidebar control-sidebar-dark elevation-4" style="display: none;">
    {{-- LOGO--}}
    <a href="#" class="brand-link">
        <img src="{{asset('logo/img/iconLogoCorporatix120x142.png')}}" alt="AdminLTE Logo" style="opacity: .8" width="40">
        <span class="brand-text font-weight-light m-2">Soclima</span>
    </a>

    {{-- SIDEBAR --}}
    <div class="sidebar">

        {{-- FOTO E NOME--}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{URL::to('/')}}/public/avatar_users/{{Auth::user()->avatar}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('user.show', ['user' => Auth::user()->id]) }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        {{-- MENU SIDEBAR--}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="suporteContent">

                {{--@can('app.dashboard')
                CONFIGURAÇÕES
                <li class="nav-item {{Route::current()->getName() === 'config.show' ? 'menu-open' : ''}}">
                    <a class="nav-link {{Route::current()->getName() === 'config.show' || '' ? 'active menu-open' : ''}}" href="{{route('config.show')}}">
                        <i class="fas fa-cog nav-icon"></i>
                        <p>Configurações</p>
                    </a>
                </li>
                @endcan --}}

                <li class="nav-item {{Route::current()->getName() === 'index' ? 'menu-open' : ''}}">
                <a href="#" class="nav-link">
                        <i class="fas fa-address-book nav-icon"></i>
                        <p>
                            Agenda Telefônica
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'telefones.index' ? 'menu-open' : ''}}">
                            <a href="{{route('telefones.index')}}" class="nav-link {{Route::current()->getName() === 'telefones.index' ? 'active menu-open' : ''}}">
                            <i class="fas fa-angle-right nav-icon"></i>
                                <p>Lista Telefônica</p>
                            </a>
                        </li>
                        @can('app.dashboard')
                            <li class="nav-item {{Route::current()->getName() === 'telefones.create' ? 'menu-open' : ''}}">
                                <a href="{{route('telefones.create')}}" class="nav-link {{Route::current()->getName() === 'telefones.create' ? 'active menu-open' : ''}}">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Adicionar Contato</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{--NOTÍCIAS --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-newspaper"></i>
                        <p>
                            Posts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'post.all' ? 'menu-open' : ''}}">
                            <a href="{{route('post.all')}}" class="nav-link {{Route::current()->getName() === 'post.all' ? 'active menu-open' : ''}}">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Listar posts</p>
                            </a>
                        </li>
                        @can('app.dashboard')
                            <li class="nav-item {{Route::current()->getName() === 'post.create' ? 'menu-open' : ''}}">
                                <a href="{{route('post.create')}}" class="nav-link {{Route::current()->getName() === 'post.create' ? 'active menu-open' : ''}}">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Criar post</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('app.dashboard')
                {{--USUÁRIOS --}}
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuários
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'user.index' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'user.index' || '' ? 'active menu-open' : ''}}" href="{{route('user.index')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar usuários</p>
                            </a>
                        </li>
                        <li class="nav-item {{Route::current()->getName() === 'user.create' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'user.create' || '' ? 'active menu-open' : ''}}" href="{{route('user.create')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Cadastrar usuário</p>
                            </a>
                        </li>
                        <li class="nav-item {{Route::current()->getName() === 'user.pedidos' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'user.pedidos' || '' ? 'active menu-open' : ''}}" href="{{route('user.pedidos')}}">
                                <i class="fas fa-cog nav-icon"></i>
                                <p>Solicitações</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                {{--CATEGORIAS --}}
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-archive"></i>
                        <p>
                            Categoria
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'categoria.index' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'categoria.index' ? 'active menu-open' : ''}}" href="{{route('categoria.index')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar categorias</p>
                            </a>
                        </li>
                        @can('app.users.create')
                            <li class="nav-item {{Route::current()->getName() === 'categoria.create' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'categoria.create' ? 'active menu-open' : ''}}" href="{{route('categoria.create')}}">
                                    <i class="fas fa-caret-right nav-icon"></i>
                                    <p>Cadastrar categoria</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li> -->

                {{--CARGO --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Cargo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'cargo.index' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'cargo.index' ? 'active menu-open' : ''}}" href="{{route('cargo.index')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar cargos</p>
                            </a>
                        </li>
                        @can('app.users.create')
                            <li class="nav-item {{Route::current()->getName() === 'cargo.create' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'cargo.create' ? 'active menu-open' : ''}}" href="{{route('cargo.create')}}">
                                    <i class="fas fa-caret-right nav-icon"></i>
                                    <p>Cadastrar cargo</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{--UNIDADE --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Departamentos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'unidade.index' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'unidade.index' ? 'active menu-open' : ''}}" href="{{route('unidade.index')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar de Departamentos</p>
                            </a>
                        </li>
                        @can('app.users.create')
                            <li class="nav-item {{Route::current()->getName() === 'unidade.create' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'unidade.create' ? 'active menu-open' : ''}}" href="{{route('unidade.create')}}">
                                    <i class="fas fa-caret-right nav-icon"></i>
                                    <p>Cadastrar Departamentos</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{--QUESTIONARIO --}}
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>
                            Questionarios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('app.dashboard')
                            <li class="nav-item {{Route::current()->getName() === 'questionario.index' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'questionario.index' ? 'active menu-open' : ''}}" href="{{route('questionario.index')}}">
                                    <i class="fas fa-cog nav-icon"></i>
                                    <p>Administrar questionários</p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item {{Route::current()->getName() === 'quest.do.finaliza' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'quest.do.finaliza' ? 'active menu-open' : ''}}" href="{{route('quest.do.finaliza')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar questionarios</p>
                            </a>
                        </li>
                        @can('app.users.create')
                            <li class="nav-item {{Route::current()->getName() === 'questionario.create' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'questionario.create' ? 'active menu-open' : ''}}" href="{{route('questionario.create')}}">
                                    <i class="fas fa-caret-right nav-icon"></i>
                                    <p>Cadastro Questionario</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li> -->

                @can('app.roles.index')
                {{--ROLES --}}
                <li class="nav-item p-0">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-grip-vertical"></i>
                        <p>
                            Permissões
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{Route::current()->getName() === 'role.index' ? 'menu-open' : ''}}">
                            <a class="nav-link {{Route::current()->getName() === 'role.index' ? 'active menu-open' : ''}}" href="{{route('role.index')}}">
                                <i class="fas fa-caret-right nav-icon"></i>
                                <p>Listar permissões</p>
                            </a>
                        </li>
                        @can('app.roles.create')
                            <li class="nav-item {{Route::current()->getName() === 'role.create' ? 'menu-open' : ''}}">
                                <a class="nav-link {{Route::current()->getName() === 'role.create' ? 'active menu-open' : ''}}" href="{{route('role.create')}}">
                                    <i class="fas fa-caret-right nav-icon"></i>
                                    <p>Cadastro permissão</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcan

            </ul>
        </nav>
    </div>

</aside>