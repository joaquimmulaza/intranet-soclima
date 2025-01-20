@extends('master.layout')
@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências > Faltas > Justificativos</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<div class="main_container manager_doc justify-content-end">
            <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar</a>
        </div>
        
<div class="main_container docs_container">
<hr class="custom_hr_justificativos">
@foreach ($ausencias as $ausencia)
<a class="view_justificativos" href="{{ route('documents.visualizar', $ausencia->id) }}">
    
    <table class="docs_table">
        <thead>
            <tr>
                <th style="position: relative; left: 14px;">Status</th>
                <th class="th_justificativos">Nome do Trabalhador</th>
                <th >Departamento</th>
                <th>Motivo</th>
                <th class="th_tipo_registo_justificativos">Tipo de registo</th>
                <th ></th>
            </tr>
            
        </thead>
        
        <tbody>
        
            <tr>
                
                <td class="iconDocsTable">
                    
                
                @if($ausencia->arquivo_comprovativo)
                <span class="show_when_hover globla_status_style {{ $ausencia->status }}">{{  $ausencia->status }}</span>
                
                    <svg id="hidden_when_hover "  width="43" height="55" viewBox="0 0 43 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M42.1509 11.5566L41.4197 10.8255L31.8469 1.25267L31.1158 0.521552C30.7848 0.190603 30.3259 0 29.8565 0H2.3356C1.21095 0 0 0.868621 0 2.77466V36.9828V52.6644V53.1034C0 53.8972 0.798449 54.6709 1.74293 54.9147C1.79035 54.927 1.83586 54.945 1.88517 54.9545C2.0331 54.9839 2.18388 55 2.3356 55H40.3368C40.4885 55 40.6393 54.9839 40.7872 54.9545C40.8366 54.945 40.8821 54.927 40.9295 54.9147C41.874 54.6709 42.6724 53.8972 42.6724 53.1034V52.6644V36.9828V13.255C42.6724 12.5277 42.5852 11.9909 42.1509 11.5566ZM39.2918 11.3793H31.2931V3.3806L39.2918 11.3793ZM2.3356 53.1034C2.26828 53.1034 2.20759 53.0788 2.14785 53.057C1.99991 52.9868 1.89655 52.8389 1.89655 52.6644V38.8793H40.7759V52.6644C40.7759 52.8389 40.6725 52.9859 40.5246 53.057C40.4648 53.0788 40.4041 53.1034 40.3368 53.1034H2.3356ZM1.89655 36.9828V2.77466C1.89655 2.56888 1.92785 1.89655 2.3356 1.89655H29.4516C29.4203 2.01603 29.3966 2.13931 29.3966 2.26733V13.2759H40.4051C40.5331 13.2759 40.6554 13.2522 40.7749 13.2209C40.7749 13.2351 40.7759 13.2408 40.7759 13.255V36.9828H1.89655Z" fill="#555555"/>
                            <path d="M14.7379 42.4297C14.4221 42.1708 14.0655 41.9755 13.6682 41.8465C13.2709 41.7166 12.8688 41.6521 12.4629 41.6521H9.71484V51.2069H11.271V47.758H12.425C12.9257 47.758 13.3847 47.685 13.7991 47.538C14.2135 47.3911 14.5681 47.1834 14.8621 46.916C15.156 46.6486 15.3846 46.3176 15.5496 45.9241C15.7136 45.5305 15.7961 45.0924 15.7961 44.6079C15.7961 44.1499 15.6985 43.7374 15.5041 43.3694C15.3097 43.0015 15.0536 42.6895 14.7379 42.4297ZM14.148 45.5865C14.0523 45.8501 13.928 46.0549 13.7725 46.2019C13.617 46.3489 13.4463 46.4551 13.2604 46.5196C13.0746 46.5841 12.8859 46.6173 12.6962 46.6173H11.27V42.8318H12.4364C12.8337 42.8318 13.1533 42.8943 13.3961 43.0195C13.6379 43.1447 13.8256 43.3002 13.9603 43.4861C14.094 43.6719 14.1822 43.8663 14.2258 44.0693C14.2685 44.2722 14.2903 44.4514 14.2903 44.6069C14.2903 44.9967 14.2429 45.3229 14.148 45.5865Z" fill="#555555"/>
                            <path d="M24.1367 43.0518C23.7347 42.6288 23.2292 42.2884 22.6195 42.0343C22.0097 41.7801 21.3033 41.6521 20.5001 41.6521H17.6221V51.2069H21.2388C21.3592 51.2069 21.5451 51.1918 21.7964 51.1614C22.0467 51.1311 22.3236 51.0628 22.6261 50.9537C22.9286 50.8456 23.2416 50.6835 23.5659 50.4673C23.8902 50.2511 24.1813 49.9552 24.4411 49.5787C24.701 49.2023 24.9143 48.7357 25.0831 48.1781C25.2519 47.6205 25.3363 46.9482 25.3363 46.1621C25.3363 45.5912 25.2367 45.0355 25.0385 44.496C24.8384 43.9574 24.5388 43.4756 24.1367 43.0518ZM23.0026 49.0543C22.536 49.7286 21.7755 50.0652 20.721 50.0652H19.1782V42.8308H20.0857C20.8291 42.8308 21.4341 42.9285 21.9007 43.1229C22.3672 43.3173 22.7371 43.5724 23.0092 43.8881C23.2814 44.2039 23.4644 44.5557 23.5602 44.9445C23.655 45.3333 23.7024 45.7268 23.7024 46.1242C23.7024 47.4034 23.4691 48.3811 23.0026 49.0543Z" fill="#555555"/>
                            <path d="M27.5928 51.2069H29.1745V46.9027H33.1677V45.8397H29.1745V42.8318H33.5688V41.6521H27.5928V51.2069Z" fill="#555555"/>
                            <path d="M30.2765 21.7734C29.4051 21.7734 28.3354 21.8872 27.0922 22.1128C25.3569 20.2713 23.5457 17.582 22.2674 14.942C23.5352 9.60414 22.9008 8.84836 22.6211 8.49181C22.3233 8.1125 21.9033 7.49707 21.4253 7.49707C21.2252 7.49707 20.679 7.5881 20.4619 7.66017C19.9157 7.84224 19.6217 8.26328 19.3865 8.81233C18.7161 10.3798 19.6359 13.0521 20.5823 15.1117C19.7734 18.3292 18.4165 22.1802 16.9902 25.3057C13.3963 26.9519 11.4874 28.5687 11.3148 30.1116C11.2522 30.6729 11.385 31.497 12.3721 32.2376C12.6424 32.4396 12.9591 32.5467 13.2891 32.5467C14.1189 32.5467 14.9571 31.9114 15.9272 30.5487C16.6346 29.5549 17.3942 28.1998 18.187 26.5176C20.7265 25.4072 23.8681 24.4039 26.5583 23.8416C28.0566 25.2801 29.3984 26.0084 30.5515 26.0084C31.4012 26.0084 32.1295 25.6177 32.6567 24.879C33.2058 24.1099 33.3309 23.4215 33.0265 22.8307C32.6615 22.1204 31.7615 21.7734 30.2765 21.7734ZM13.31 30.946C12.8662 30.6056 12.8918 30.3761 12.9013 30.2898C12.9601 29.7626 13.786 28.8266 15.8125 27.6878C14.2763 30.525 13.4513 30.9015 13.31 30.946ZM21.0859 9.20966C21.1266 9.19638 22.0768 10.2537 21.1769 12.2593C19.8246 10.8758 20.9929 9.24095 21.0859 9.20966ZM19.1258 24.4067C20.0883 22.1128 20.9834 19.58 21.6615 17.234C22.7264 19.1476 24.0056 21.0043 25.2858 22.4912C23.2621 22.9663 21.1077 23.6367 19.1258 24.4067ZM31.3595 23.9525C31.0674 24.3612 30.434 24.3707 30.2121 24.3707C29.7066 24.3707 29.5179 24.0701 28.7451 23.4755C29.3823 23.394 29.9835 23.3731 30.4624 23.3731C31.3054 23.3731 31.46 23.4973 31.5766 23.5599C31.5558 23.6272 31.5008 23.7543 31.3595 23.9525Z" fill="#555555"/>
                        </svg>
                    @else
                    <span class=" show_when_hover globla_status_style {{ $ausencia->status }}">{{  $ausencia->status }}</span>
                    <svg class=" hidden_when_hover" width="44" height="56" viewBox="0 0 44 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M40.052 38.5026L38.6858 37.1418L40.9532 34.8575L42.3363 36.2357L40.052 38.5026ZM37.2924 35.7842L35.3282 33.8205V29.9304H37.2924V35.7842ZM29.9532 47.9519V45.9882H40.7444L13.3458 18.5896V38.2701C13.3458 38.4138 13.4018 38.5416 13.5138 38.6536C13.6258 38.7655 13.7536 38.8215 13.8972 38.8215H26.7488V40.7852H13.8972C13.2364 40.7852 12.652 40.5312 12.1441 40.0233C11.6361 39.5153 11.3822 38.931 11.3822 38.2701V16.6255L6 11.2661L7.35226 9.88252L43.4526 45.9828V47.9519H29.9532ZM35.3282 26.726H37.2924V19.5974L27.195 9.5H13.8981C13.4681 9.5 13.0874 9.58645 12.7559 9.75935C12.4245 9.93224 12.1532 10.1543 11.9421 10.4254L13.1788 11.6706C13.2361 11.6133 13.3021 11.5646 13.3767 11.5246C13.4514 11.4843 13.5232 11.4641 13.5922 11.4641H26.3699V20.4224H35.3282V26.726Z" fill="#5F6368"/>
                    </svg>

                    @endif
                </td>

                <td class="td_user_name_justificativos">
                    <!-- <div style="padding-left: 26px;">
                        <svg  width="43" height="55" viewBox="0 0 43 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M42.1509 11.5566L41.4197 10.8255L31.8469 1.25267L31.1158 0.521552C30.7848 0.190603 30.3259 0 29.8565 0H2.3356C1.21095 0 0 0.868621 0 2.77466V36.9828V52.6644V53.1034C0 53.8972 0.798449 54.6709 1.74293 54.9147C1.79035 54.927 1.83586 54.945 1.88517 54.9545C2.0331 54.9839 2.18388 55 2.3356 55H40.3368C40.4885 55 40.6393 54.9839 40.7872 54.9545C40.8366 54.945 40.8821 54.927 40.9295 54.9147C41.874 54.6709 42.6724 53.8972 42.6724 53.1034V52.6644V36.9828V13.255C42.6724 12.5277 42.5852 11.9909 42.1509 11.5566ZM39.2918 11.3793H31.2931V3.3806L39.2918 11.3793ZM2.3356 53.1034C2.26828 53.1034 2.20759 53.0788 2.14785 53.057C1.99991 52.9868 1.89655 52.8389 1.89655 52.6644V38.8793H40.7759V52.6644C40.7759 52.8389 40.6725 52.9859 40.5246 53.057C40.4648 53.0788 40.4041 53.1034 40.3368 53.1034H2.3356ZM1.89655 36.9828V2.77466C1.89655 2.56888 1.92785 1.89655 2.3356 1.89655H29.4516C29.4203 2.01603 29.3966 2.13931 29.3966 2.26733V13.2759H40.4051C40.5331 13.2759 40.6554 13.2522 40.7749 13.2209C40.7749 13.2351 40.7759 13.2408 40.7759 13.255V36.9828H1.89655Z" fill="#555555"/>
                            <path d="M14.7379 42.4297C14.4221 42.1708 14.0655 41.9755 13.6682 41.8465C13.2709 41.7166 12.8688 41.6521 12.4629 41.6521H9.71484V51.2069H11.271V47.758H12.425C12.9257 47.758 13.3847 47.685 13.7991 47.538C14.2135 47.3911 14.5681 47.1834 14.8621 46.916C15.156 46.6486 15.3846 46.3176 15.5496 45.9241C15.7136 45.5305 15.7961 45.0924 15.7961 44.6079C15.7961 44.1499 15.6985 43.7374 15.5041 43.3694C15.3097 43.0015 15.0536 42.6895 14.7379 42.4297ZM14.148 45.5865C14.0523 45.8501 13.928 46.0549 13.7725 46.2019C13.617 46.3489 13.4463 46.4551 13.2604 46.5196C13.0746 46.5841 12.8859 46.6173 12.6962 46.6173H11.27V42.8318H12.4364C12.8337 42.8318 13.1533 42.8943 13.3961 43.0195C13.6379 43.1447 13.8256 43.3002 13.9603 43.4861C14.094 43.6719 14.1822 43.8663 14.2258 44.0693C14.2685 44.2722 14.2903 44.4514 14.2903 44.6069C14.2903 44.9967 14.2429 45.3229 14.148 45.5865Z" fill="#555555"/>
                            <path d="M24.1367 43.0518C23.7347 42.6288 23.2292 42.2884 22.6195 42.0343C22.0097 41.7801 21.3033 41.6521 20.5001 41.6521H17.6221V51.2069H21.2388C21.3592 51.2069 21.5451 51.1918 21.7964 51.1614C22.0467 51.1311 22.3236 51.0628 22.6261 50.9537C22.9286 50.8456 23.2416 50.6835 23.5659 50.4673C23.8902 50.2511 24.1813 49.9552 24.4411 49.5787C24.701 49.2023 24.9143 48.7357 25.0831 48.1781C25.2519 47.6205 25.3363 46.9482 25.3363 46.1621C25.3363 45.5912 25.2367 45.0355 25.0385 44.496C24.8384 43.9574 24.5388 43.4756 24.1367 43.0518ZM23.0026 49.0543C22.536 49.7286 21.7755 50.0652 20.721 50.0652H19.1782V42.8308H20.0857C20.8291 42.8308 21.4341 42.9285 21.9007 43.1229C22.3672 43.3173 22.7371 43.5724 23.0092 43.8881C23.2814 44.2039 23.4644 44.5557 23.5602 44.9445C23.655 45.3333 23.7024 45.7268 23.7024 46.1242C23.7024 47.4034 23.4691 48.3811 23.0026 49.0543Z" fill="#555555"/>
                            <path d="M27.5928 51.2069H29.1745V46.9027H33.1677V45.8397H29.1745V42.8318H33.5688V41.6521H27.5928V51.2069Z" fill="#555555"/>
                            <path d="M30.2765 21.7734C29.4051 21.7734 28.3354 21.8872 27.0922 22.1128C25.3569 20.2713 23.5457 17.582 22.2674 14.942C23.5352 9.60414 22.9008 8.84836 22.6211 8.49181C22.3233 8.1125 21.9033 7.49707 21.4253 7.49707C21.2252 7.49707 20.679 7.5881 20.4619 7.66017C19.9157 7.84224 19.6217 8.26328 19.3865 8.81233C18.7161 10.3798 19.6359 13.0521 20.5823 15.1117C19.7734 18.3292 18.4165 22.1802 16.9902 25.3057C13.3963 26.9519 11.4874 28.5687 11.3148 30.1116C11.2522 30.6729 11.385 31.497 12.3721 32.2376C12.6424 32.4396 12.9591 32.5467 13.2891 32.5467C14.1189 32.5467 14.9571 31.9114 15.9272 30.5487C16.6346 29.5549 17.3942 28.1998 18.187 26.5176C20.7265 25.4072 23.8681 24.4039 26.5583 23.8416C28.0566 25.2801 29.3984 26.0084 30.5515 26.0084C31.4012 26.0084 32.1295 25.6177 32.6567 24.879C33.2058 24.1099 33.3309 23.4215 33.0265 22.8307C32.6615 22.1204 31.7615 21.7734 30.2765 21.7734ZM13.31 30.946C12.8662 30.6056 12.8918 30.3761 12.9013 30.2898C12.9601 29.7626 13.786 28.8266 15.8125 27.6878C14.2763 30.525 13.4513 30.9015 13.31 30.946ZM21.0859 9.20966C21.1266 9.19638 22.0768 10.2537 21.1769 12.2593C19.8246 10.8758 20.9929 9.24095 21.0859 9.20966ZM19.1258 24.4067C20.0883 22.1128 20.9834 19.58 21.6615 17.234C22.7264 19.1476 24.0056 21.0043 25.2858 22.4912C23.2621 22.9663 21.1077 23.6367 19.1258 24.4067ZM31.3595 23.9525C31.0674 24.3612 30.434 24.3707 30.2121 24.3707C29.7066 24.3707 29.5179 24.0701 28.7451 23.4755C29.3823 23.394 29.9835 23.3731 30.4624 23.3731C31.3054 23.3731 31.46 23.4973 31.5766 23.5599C31.5558 23.6272 31.5008 23.7543 31.3595 23.9525Z" fill="#555555"/>
                        </svg>
                    </div> -->

                    <div>
                    {{  $ausencia->user->name  }} <br>
                        <span style="font-weight: 400; font-size: 13px;"> {{  $ausencia->user->cargo->titulo  }}s</span>
                    </div>
                </td>
                <td class="data_documents">{{  $ausencia->user->unidade->titulo  }} </td>
                <td class="data_documents">{{  $ausencia->motivo  }} </td>
                <td class="data_documents td_tipo_registo_justificativos">{{$ausencia->tipo_registo}}</td>
                <td class="OptDocs">
                    
                    <div class="containerOpt">
                        <!-- class .btnOpt removida -->
                        <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-{{ $ausencia->id }}" style="margin: 0 !important; padding: 0 !important;">
                            <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                        </button>
                        <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{ $ausencia->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt_justificativos">
                                        @if($ausencia->status === 'Pendente')
                                        <form action="{{ route('ausencias.aprovarRejeitar', $ausencia->id) }}" method="POST" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Aprovado">
                                            <button style="border-bottom: none;border-top-right-radius: 5px;    border-top-left-radius: 5px;" type="submit" class="btnPosts ">
                                                Aprovar
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('ausencias.aprovarRejeitar', $ausencia->id) }}" method="POST" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Rejeitado">
                                            <button style="border-bottom: none;" type="submit" class="btnPosts">
                                                Rejeitar
                                            </button>
                                        </form>
                                        <button style="border-bottom-right-radius: 5px;    border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{ $ausencia->id }}">
                                                Apagar da lista
                                            </button>
                                            <form id="delete-form-{{ $ausencia->id }}"
                                                    action="{{ route('ausencias.destroy', $ausencia->id) }}" method="POST" style="display: none;" class="btn-popup">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @else
                                        <button style="border-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{ $ausencia->id }}">
                                                Apagar da lista
                                            </button>
                                            <form id="delete-form-{{ $ausencia->id }}"
                                                    action="{{ route('ausencias.destroy', $ausencia->id) }}" method="POST" style="display: none;" class="btn-popup">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        @endif   
                                            
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</a>
    <div style="margin-bottom: 20px;"></div> <!-- Espaçamento explícito entre tabelas -->
@endforeach


</div>
<p class="info-time-doc">Faltas sem qualquer comunicação prévia serão consideradas injustificadas, caso não seja apresentado o devido justificativo</p>

<script>
    $('.modalOpt').on('show.bs.modal', function () {
        $('body').addClass('modal-open-no-backdrop');
    });

    $('.modalOpt').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open-no-backdrop');
    });

    $(document).on('click', function (event) {
        const $modal = $('.modalOpt');
        if ($modal.is(':visible') && !$(event.target).closest('.modal-content').length) {
            $modal.modal('hide');
        }
    });

    function deleteData(id) {
    const form = document.getElementById(`delete-form-${id}`);
    if (form) {
        form.submit();
    } else {
        console.error(`Formulário com ID delete-form-${id} não encontrado.`);
    }
}

document.querySelectorAll('.view_justificativos .btn-popup').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
    });

    function deleteData(event, id) {
    event.stopPropagation(); // Impede que o clique no botão acione o evento no <a>
    event.preventDefault(); // Opcional, caso queira evitar comportamentos padrões de envio ou navegação

    // Lógica para deletar o dado
    console.log(`Deletando dado com ID: ${id}`);
    alert(`Confirma exclusão do item ${id}?`);
    // Faça a requisição de exclusão ou qualquer outra ação aqui
}
});

document.querySelectorAll('.btnPostsDelete').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.stopPropagation(); // Impede que o clique se propague para o link pai
        event.preventDefault();   // Impede o comportamento padrão de navegação

        var id = button.getAttribute('data-id'); // Obtém o ID do atributo data-id
    
    });
});

function deleteData(id) {
    console.log('Deletando item com ID:', id); // Log para ver o ID no console
    
    // Aqui, você pode fazer a chamada AJAX ou redirecionar, dependendo de como você quer excluir o item
    // Exemplo de chamada AJAX usando fetch:
    fetch(`/ausencias/${id}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
.then(response => {
    if (response.ok) {
        return response.json(); // A resposta agora será um JSON
    } else {
        return Promise.reject('Falha ao excluir o item.'); // Caso o status não seja 2xx
    }
})
.then(data => {
    console.log('Item deletado com sucesso:', data.message);
    location.reload();
    // Aqui você pode realizar ações como remover o item da lista na UI
})
.catch(error => {
    console.error('Erro:', error);
    alert('Erro ao tentar excluir o item.');
});

}


document.addEventListener('DOMContentLoaded', function () {
        // Selecionar todos os botões de exclusão
        const deleteButtons = document.querySelectorAll('.btnPostsDelete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const documentId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apagar da lista',
                    text: "Tem certeza que deseja apagar este item da lista?",
                    showCancelButton: true,
                    confirmButtonColor: '#fff',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    customClass: {
                    confirmButtonColor: 'deleteButton_alert',
                    cancelButtonColor: 'cancelButton_alert',
                    title: 'title_delete_alert',
                    popup: 'popup_delete_alert',
                    },	
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Fazer a requisição de exclusão via AJAX
                        deleteDocument(documentId);
                    }
                });
            });
        });

        function deleteDocument(documentId) {
            fetch(`/ausencias/${documentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição');
            }
            return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: data.message,
                    timer: 6000,
                    position: "bottom-start",
                    imageUrl: "{{asset('logo/img/icon/verified.gif')}}",
                    imageAlt: "Custom image",
                    imageWidth: 40,
                    showConfirmButton: false,
                    width: 225,
                    backdrop: false,
                    customClass: {
                        popup: 'container_sweet_justificativos',
                        icon: 'icon_sweet_justificativos',
                        title: 'title_sweet_justificativos',
                        image: 'img_sweet_justificativos',
                        
                    }
                });

                // Atualizar a página ou remover o elemento da lista
                setTimeout(() => {
                    location.reload();
                }, 1500);
            })
            .catch(error => {
                Swal.fire(
                    'Erro!',
                    'Houve um problema ao excluir o documento.',
                    'error'
                );
            });
        }
    });
</script>
@endsection