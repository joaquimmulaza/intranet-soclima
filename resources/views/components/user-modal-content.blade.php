
<div class="modal fade show cardUserView escurecer" id="cardUserViewNav-{{ $user->id }}" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-dismiss="modal" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-header-center">
                                        <img src="{{URL::to('/')}}/public/avatar_users/{{$user->avatar}}" alt="Foto do perfil">
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true"><img src="{{ asset('logo/img/icon/clear.svg') }}" alt=""></span>
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
                                            <a href="{{ route('user.edit', ['user' => $user->id]) }}">
                                                <img src="{{ asset('logo/img/icon/icon-edit.svg') }}" alt="">
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
                                                <img class="size-g-icon" src="{{ asset('logo/img/icon/cake.svg') }}" alt="">
                                                <span class="">Data de nascimento:</span>
                                            </div>
                                            <span>{{date('d/m/Y', strtotime($user->nascimento))}}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/gender.svg')}}" alt="">
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
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/call.svg')}}" alt="">
                                                <span>Telemóvel da firma</span>
                                            </div>
                                            <span></span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/call.svg')}}" alt="">
                                                <span>Telemóvel pessoal:</span>
                                            </div>
                                            <span>{{ $user->fone }}</span>
                                        </div>
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/mail.svg')}}" alt="">
                                                <span>E-mail</span>
                                            </div>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                        
                                        <div class="dadosPessoais">
                                            <div>
                                                <img class="size-g-icon" src="{{asset('logo/img/icon/numbers.svg')}}" alt="">
                                                <span class="">Nº mecanográfico:</span>
                                            </div>
                                            <span>{{ $user->numero_mecanografico }}</span>
                                        </div>

                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
