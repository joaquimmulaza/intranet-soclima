@extends('master.layout')
@section('content')


<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Documentos solicitados</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>
<!-- <div class="main_container manager_doc justify-content-end">
            <a href="{{ route('documents.index') }}" class="globalBtn_with_border right_side">Voltar</a>
        </div> -->
        
<div class="main_container docs_container">
<hr class="custom_hr_justificativos">
@forelse ($requests as $request)
<a class="view_justificativos" href="{{ route('documento-solicitado.show', $request->id) }}">
    
    <table class="docs_table">
        <thead>
            <tr>
                <th style="position: relative; left: 14px;">Status</th>
                <th class="th_justificativos">Tipo de documento</th>
                <th style="padding-left: 36px;">Solicitado por</th>
                <th style="padding-left: 20px;">Prazo de entrega</th>
                <th class="th_tipo_registo_justificativos">Forma de entrega</th>
                <th ></th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                
                <td class="iconDocsTableSolicitados" style="width: 100px !important; padding-left: 13px;">
                    
                <span class="{{ $request->status }}" style="width: 69px !important; display: flex; align-items: center; justify-content: center;"> 
                    @if($request->status == 'concluído')
                    Pronto
                    @else
                    Pendente
                    @endif
                </span>
                
                </td>

                <td class="" style="width: 310px !important;">
                    <div>
                        {{ $request->tipo_documento }}<br>
                        <span style="font-weight: 400; font-size: 13px;">{{ $request->finalidade }}</span>
                    </div>
                </td>
                <td class="data_documents" style=" padding-left: 36px; font-weight: 700 !important;">{{ $request->user->name }}</td>
                <td class="data_documents" style="padding-left: 20px;">{{$request->prazo_entrega}}</td>
                <td class="data_documents td_tipo_registo_justificativos">{{ ucfirst($request->forma_entrega) }}</td>
                <td class="OptDocs">
                    
                    <div class="containerOpt">
                        <!-- class .btnOpt removida -->
                        <button class=" more_opt btn-popup"  data-toggle="modal" data-target="#modalOptPhone-{{$request->id}}" style="margin: 0 !important; padding: 0 !important;">
                            <img src="{{asset('logo/img/icon/more_opt.svg')}}" alt="">
                        </button>
                        <div class="modal fade modalOpt modalOpt_justificativos" id="modalOptPhone-{{$request->id}}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body modal-bodyOpt">
                                        <div class="containerBtnOpt_justificativos">
                                
                                        <form action="" method="POST" class="">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="Aprovado">
                                            <button style="border-bottom: none;border-top-right-radius: 5px;    border-top-left-radius: 5px;" type="submit" class="btnPosts ">
                                                Enviar
                                            </button>
                                        </form>
                                  
                                        <button style="border-bottom-right-radius: 5px;    border-bottom-left-radius: 5px;" type="button" class="btnPosts btnPostsDelete "  data-id="{{$request->id}}">
                                                Apagar da lista
                                            </button>
                                            <form id="delete-form-{{$request->id}}"
                                                    action="{{route('documento-solicitado.destroy', $request->id)}}" method="POST" style="display: none;" class="btn-popup">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
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

    @empty
    <style>
        .main_container{
            background: none !important;
        }
        .custom_hr_justificativos{
            display: none !important;
        }
    </style>
    <div class="text-center containerEmptyPage">
        <img src="{{asset('logo/img/icon/standard_doc_request.svg')}}" alt="">
        <h1 class="titleEmptyPage">Nenhum documento solicitado</h1>
        <p class="sentenceEmptyPage">Quando um documento for solicitado, poderá gerenciá-lo aqui.</p>
    </div>
@endforelse

</div>

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
    fetch(`/documento-solicitado/${id}`, {
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
            fetch(`/documento-solicitado/${documentId}`, {
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