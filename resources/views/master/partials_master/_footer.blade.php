
<footer class="page-footer btn-mdb-color text-center text-md-left hidden">
    <div class="container">
        <div style="display: none;" class="row text-center text-md-left mt-4 pb-3 justify-content-center">

            {{-- SOBRE RODAPÉ--}}
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold">Sobre a empresa</h6>
                <p>
                Desde 1991 uma referência no mercado angolano, reconhecida pela qualidade, profissionalismo e eficiência.

                </p>
            </div>

            <hr class="w-100 clearfix d-md-none">

            {{-- CATEGORIAS RODAPÉ--}}
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mx-auto mt-3 text-center">
                <h6 class="text-uppercase font-weight-bold">Categorias</h6>

                {{--NOTÍCIAS --}}
                <p class="mb-1">
                    <a href="{{route('post.all')}}">
                        Posts
                    </a>
                </p>

                @can('app.dashboard')
                {{--USUÁRIOS --}}
                <p class="mb-1">
                    <a href="{{route('user.index')}}">
                        Usuários
                    </a>
                </p>
                @endcan

                {{--CATEGORIAS --}}
                <!-- <p class="mb-1">
                    <a href="{{route('categoria.index')}}">
                        Categorias
                    </a>
                </p> -->

                {{--CARGO --}}
                <p class="mb-1">
                    <a href="{{route('cargo.index')}}">
                        Cargos
                    </a>
                </p>

                {{--UNIDADE --}}
                <p class="mb-1">
                    <a href="{{route('unidade.index')}}">
                        Departamentos
                    </a>
                </p>

                {{--QUESTIONARIO --}}
                <!-- <p class="mb-1">
                    <a href="{{route('quest.do.finaliza')}}">
                        Questionarios
                    </a>
                </p> -->

                @can('app.dashboard')
                <p class="mb-1">
                    <a href="{{route('role.index')}}">
                        Permissões
                    </a>
                </p>
                @endcan
            </div>

            <hr class="w-100 clearfix d-md-none">

            

        </div>
        

        {{-- DOMÍNIO E MIDIAS SOCIAIS RODAPÉ--}}
        <div class="row py-3 d-flex justify-content-between align-items-center">
            {{-- CONTATO RODAPÉ--}}
            
            {{-- DOMÍNIO RODAPÉ--}}
            <div class="">
                <p class="text-center text-md-left text-white">
                    Copyright &copy; {{date('Y')}} <a href="https://soclima.com/" target="_blank">Soclima</a>
                </p>
            </div>

            <div class="">
                <!-- <h6 class="text-uppercase mb-4 font-weight-bold">Contato</h6> -->
                <p>AV. Samora Machel. S/N. Luanda. Talatona</p>
                <!-- <p>
                    <i class="fas fa-envelope mr-3"></i>geral@soclima.com</p>
                <p> -->
                    <!-- <i class="fas fa-phone mr-3"></i>+244 923170012</p> -->
                <!-- <p>
                    <i class="fas fa-print mr-3"></i> + (51)33555555</p> -->
            </div>

            {{-- MIDIAS SOCIAIS RODAPÉ--}}
            <div class="">
                <div class="social-section text-center text-md-left">
                    <ul class="list-unstyled list-inline">
                        <!-- <li class="list-inline-item mx-0">
                            <a href="https://www.facebook.com/rafael.blum.3" class="btn-floating btn-sm rgba-white-slight mr-xl-4 waves-effect waves-light" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li> -->
                        <li class="list-inline-item mx-0">
                            <a href="https://www.instagram.com/soclimaac/" class="btn-floating btn-sm rgba-white-slight mr-xl-4 waves-effect waves-light" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mx-0">
                            <a href="https://www.linkedin.com/company/soclima---ventila%C3%A7%C3%A3o-e-ar-condicionado/" class="btn-floating btn-sm rgba-white-slight mr-xl-4 waves-effect waves-light" target="_blank">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>