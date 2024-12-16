@extends('master.layout')
@section('title', 'Lista Telefônica')

@section('content')

<script src="{{ asset('js/formMask/jquery.inputmask.min.js') }}"></script>
{{-- CABEÇALHO BREADCRUMB --}}
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Lista Telefônica</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
</div>

<section class="containerPhones" >
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class=" card-primary">
                    <div class="cardPhoneHeader">
                        <button class="add-button" data-toggle="modal" data-target="#addContact">Adicionar</button>
                        <div class="filterContainer">
                            <input id="searchInput" class=" backgroundInput" placeholder="Pesquisar" type="text">
                            <button data-toggle="modal" data-target="#filtrar" class="filter"><img src="logo/img/icon/filter.svg" alt=""></button>
                            <div class="modal fade modalOpt" id="filtrar" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body modal-bodyOpt">
                                            <div class="containerBtnOpt">
                                                <h1>Departamento</h1>
                                                @can('app.dashboard')
                                                <button type="button" class="btnPosts" data-departamento="Comercial">
                                                Comercial
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Assistência técnica">
                                                Assistência técnica
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Oficina mecânica">
                                                Oficina mecânica
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Fabrica de Condutas">
                                                Fábrica de condutas
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Armazém">
                                                Armázem
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Operações">
                                                Operações
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Marketing">
                                                Marketing
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Importação">
                                                Importação
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Recursos Humanos">
                                                Recursos Humanos
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Financeiro">
                                                Financeiro
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Relações Públicas">
                                                Relações Públicas
                                                </button>
                                                <button type="button" class="btnPosts" data-departamento="Produção">
                                                Produção
                                                </button>
                                                <button type="button" id="resetFilter" class="btnPosts">Todos os Departamentos</button>

                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                    @php
                        $telefones = $telefones->sortBy('nome'); // Ordena pela coluna 'nome' em ordem alfabética crescente
                    @endphp

                    @foreach($telefones as $telefone)
                    
                        <table class="containerTable">
                            <thead>
                                <tr>
                                    <th style="font-weight: 700;">{{ $telefone->nome }}</th>
                                    <th>Departamento</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <tr>
                                        <td>{{ $telefone->funcao }}</td>
                                        <td style="font-weight: 700;">{{ $telefone->departamento }}</td>
                                        <td style="padding: 0; margin: 0;" >
                                            <span style="color: #009AC1; display: flex; padding: 0 0 0 9px; margin: 0; justify-content: start; gap: 4px; align-items: center; background: #EEF7FF; width: 129px !important; height: 27px; border-radius: 5px; position: relative; bottom:15px;">
                                            <img style="padding: 0; margin: 0;" src="logo/img/icon/icon-cellphone.svg" alt="">
                                            <span style="font-weight: 600;">{{ $telefone->telefone }}<span>
                                            <span>

                                        </td>
                                        <td style="padding: 0; margin: 0;" >
                                            <span style="color: #009AC1; display: flex; padding: 0 0 0 9px; margin: 0; justify-content: start; gap:4px; align-items: center; background: #EEF7FF; !important; height: 27px; width: 250px; border-radius: 5px; position: relative; bottom:15px;">
                                            <img style="padding: 0; margin: 0; font-weight: 600;" src="logo/img/icon/mail.svg" alt="">
                                            <span style="font-weight: 600; ">{{ $telefone->email }}<span>
                                            <span>

                                        </td>
                                       
                                        <td style="display: flex; justify-content: center;">
                                            <a href="{{ route('telefones.edit', $telefone->id) }}" class="btn btn-warning btn-sm hidden" style="display: none;">Editar</a>
                                            <form action="{{ route('telefones.destroy', $telefone->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm hidden" onclick="return confirm('Tem certeza que deseja excluir este telefone?')">Excluir</button>
                                            </form>
                                            <div class="containerOpt">
                                                <button class="btnOpt"  data-toggle="modal" data-target="#modalOptPhone-{{ $telefone->id }}" style="margin: 0 !important; padding: 0 !important;"><svg width="18" height="34" viewBox="0 0 18 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <ellipse cx="8.5" cy="9.90277" rx="1.5" ry="1.40278" fill="#555555"/>
                                                    <ellipse cx="8.5" cy="16.9164" rx="1.5" ry="1.40278" fill="#555555"/>
                                                    <ellipse cx="8.5" cy="23.9306" rx="1.5" ry="1.40278" fill="#555555"/>
                                                    </svg>
                                                </button>
                                                <div class="modal fade modalOpt" id="modalOptPhone-{{ $telefone->id }}" tabindex="-1" aria-labelledby="modalOptLabel" aria-hidden="true" data-backdrop="true" data-keyboard="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body modal-bodyOpt">
                                                                <div class="containerBtnOpt">
                                                                    @can('app.dashboard')
                                    
                                                                    <button type="button" data-toggle="modal" data-target="#EditContact-{{ $telefone->id }}" style="border-bottom: none;" class="btnPosts"  data-id="{{$telefone->id}}" data-nome="{{ $telefone->nome }}" 
                                                                    data-departamento="{{ $telefone->departamento }}" 
                                                                    data-funcao="{{ $telefone->funcao }}" 
                                                                    data-telefone="{{ $telefone->telefone }}" 
                                                                    data-email="{{ $telefone->email }}" >
                                                                        Editar
                                                                    </button>
                                                                    <button type="button" class="btnPosts" onClick="deleteData({{ $telefone->id }})">
                                                                        Eliminar
                                                                    </button>
                                                                    <form id="delete-form-{{ $telefone->id }}"
                                                                            action="{{ route('telefones.destroy', ['telefone' => $telefone->id]) }}" method="POST" style="display: none;">
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
                                            
                                        </td>
                                    </tr>
                                
                            </tbody>
                        </table>

                        <div class="modal fade EditContact" id="EditContact-{{ $telefone->id }}" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="formStyle" id="EditContactAjax-{{ $telefone->id }}" action="{{ route('telefones.update', ['telefone' => ':id']) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nome">Nome</label>
                                            <input type="text" name="nome" class="form-control" id="nome" placeholder="Informe o nome" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="departamento">Departamento</label>
                                            <input type="text" name="departamento" class="form-control" id="departamento" placeholder="Informe o departamento" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="funcao">Função</label>
                                            <input type="text" name="funcao" class="form-control" id="funcao" placeholder="Informe a função" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="telefone">Telefone</label>
                                            <input type="text" name="telefone" class="form-control" id="telefone" placeholder="Informe o telefone">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Informe o email (opcional)">
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btnAdd">Atualizar</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                            </div>
                        </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="AddContactAjax-{{ $telefone->id }}" class="formStyle" action="{{ route('telefones.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" id="nome" required>
                </div>

                <div class="form-group">
                    <label for="departamento">Departamento</label>
                    <input type="text" name="departamento" class="form-control" id="departamento" required>
                </div>

                <div class="form-group">
                    <label for="funcao">Função</label>
                    <input type="text" name="funcao" class="form-control" id="funcao" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Nº de telefone</label>
                    <div class="input-container">
                        <span class="prefix">+244</span>
                        <input type="tel" name="telefone" class="input-field">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email">
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btnAdd">Adicionar</button>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>




<script>
    $(document).ready(function () {
    // Modal Behavior
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

    // Quando o modal é aberto
    $('[data-toggle="modal"]').on('click', function () {
    var button = $(this);
    var id = button.data('id');
    var nome = button.data('nome');
    var departamento = button.data('departamento');
    var funcao = button.data('funcao');
    var telefone = button.data('telefone');
    var email = button.data('email');

    var modal = $('#EditContact-' + id);
    
    modal.find('#nome').val(nome);
    modal.find('#departamento').val(departamento);
    modal.find('#funcao').val(funcao);
    modal.find('#telefone').val(telefone);
    modal.find('#email').val(email);
    
    // Atualiza a ação do formulário com o ID usando Blade para o URL base
    modal.find('form').attr('action', '{{ url("/telefones") }}/' + id);
});


    // Envio do formulário via AJAX
    $('#EditContactAjax').on('submit', function (e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                $('#EditContact-' + response.id).modal('hide'); // Fecha o modal
                alert('Contato atualizado com sucesso!');
                // Você pode adicionar código aqui para atualizar a tabela ou lista de contatos
            },
            error: function (response) {
                alert('Ocorreu um erro. Por favor, tente novamente.');
            }
        });
    });

});

document.addEventListener("DOMContentLoaded", function () {
        // Seleciona todos os formulários (adicionar e editar)
        const forms = document.querySelectorAll('form[id^="AddContactAjax"], form[id^="EditContactAjax-"]');

        // Função para verificar se todos os campos obrigatórios estão preenchidos
        function checkFormValidity(form) {
            const inputs = form.querySelectorAll('input[required]');
            const button = form.querySelector('.btnAdd');
            let isValid = true;

            // Verifica se todos os campos obrigatórios estão preenchidos corretamente
            inputs.forEach(input => {
                if (!input.value.trim() || !input.checkValidity()) {
                    isValid = false;
                }
            });

            // Se o formulário for válido, habilita o botão e muda a cor
            if (isValid) {
                button.disabled = false;
                button.style.backgroundColor = '#009ac1'; // Cor verde
            } else {
                button.disabled = true;
                button.style.backgroundColor = '#e2e2e2'; // Cor cinza (desabilitado)
            }
        }

        // Adiciona eventos de 'input' para cada formulário
        forms.forEach(form => {
            // Verifica o estado do formulário ao carregar a página
            checkFormValidity(form);

            // Adiciona eventos 'input' aos campos obrigatórios de cada formulário
            const inputs = form.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    checkFormValidity(form);
                });
            });
        });
    });

//     document.getElementById('search').addEventListener('input', function () {
//     let searchTerm = this.value.toLowerCase(); // Converte o termo em minúsculas
//     let rows = document.querySelectorAll('.containerTable tbody tr'); // Seleciona todas as linhas da tabela

//     rows.forEach(function (row) {
//         let nome = row.querySelector('td:first-child').textContent.toLowerCase(); // Assume que o nome está na primeira célula
//         let departamento = row.querySelector('td:nth-child(2)').textContent.toLowerCase(); // Assume que o departamento está na segunda célula

//         if (nome.includes(searchTerm) || departamento.includes(searchTerm)) {
//             row.style.display = ''; // Mostra a linha
//         } else {
//             row.style.display = 'none'; // Esconde a linha
//         }
//     });
// });

// document.addEventListener("DOMContentLoaded", function () {
//     const searchInput = document.getElementById('searchInput');
    
//     if (searchInput) {
//         searchInput.addEventListener('input', function () {
//             filtrarPorNome(this.value);
//         });
//     }

//     function filtrarPorNome(nomePesquisa) {
//         const nomePesquisaLower = nomePesquisa.trim().toLowerCase(); // Ignora maiúsculas/minúsculas e espaços extras
//         const rows = document.querySelectorAll(' tbody tr'); // Selecione todas as linhas da tabela dentro do <tbody>
        
//         rows.forEach(row => {
//             const nomeContato = row.querySelector('td:nth-child(2)') ? row.querySelector('td:nth-child(2)').textContent.trim().toLowerCase() : ""; // Nome na primeira coluna
            
//             // Verifica se o nome do contato corresponde ao texto da pesquisa
//             if (nomeContato.includes(nomePesquisaLower)) {
//                 row.style.display = ''; // Exibe a linha
//             } else {
//                 row.style.display = 'none'; // Oculta a linha
//             }
//         });
//     }
// });



document.addEventListener('DOMContentLoaded', function () {
    // Seleciona todos os botões de filtro por departamento
    const buttons = document.querySelectorAll('.btnPosts');

    // Adiciona evento de clique em cada botão de departamento
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const departamento = this.getAttribute('data-departamento'); // Obtém o departamento do botão
            filtrarContatosPorDepartamento(departamento); // Chama a função de filtro por departamento
        });
    });

    // Função para filtrar os contatos por departamento
    function filtrarContatosPorDepartamento(departamento) {
        const tables = document.querySelectorAll('.containerTable'); // Seleciona todas as tabelas

        tables.forEach(table => {
            const rows = table.querySelectorAll('tbody tr'); // Seleciona todas as linhas da tabela
            let hasMatchingRows = false; // Flag para verificar se há linhas correspondentes ao filtro de departamento

            rows.forEach(row => {
                const depText = row.querySelector('td:nth-child(2)') ? row.querySelector('td:nth-child(2)').textContent.trim() : "";

                // Se o departamento da linha corresponder ao departamento selecionado, exibe a linha
                if (depText && depText.toLowerCase() === departamento.toLowerCase()) {
                    row.style.display = ''; // Exibe a linha
                    hasMatchingRows = true; // Marca que encontrou pelo menos uma linha correspondente
                } else {
                    row.style.display = 'none'; // Oculta a linha
                }
            });

            // Exibe ou oculta a tabela com base na correspondência de linhas
            if (hasMatchingRows) {
                table.style.display = ''; // Exibe a tabela se houver linhas correspondentes
            } else {
                table.style.display = 'none'; // Oculta a tabela se não houver linhas correspondentes
            }
        });
    }

    // Função para filtrar os contatos por nome (pesquisa)
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            filtrarPorNome(this.value); // Chama a função de filtro de pesquisa com o valor da pesquisa
        });
    }

    // Função para filtrar as linhas da tabela pelo nome
    function filtrarPorNome(nomePesquisa) {
        const nomePesquisaLower = nomePesquisa.trim().toLowerCase(); // Converte o nome para minúsculas e remove espaços
        const tables = document.querySelectorAll('.containerTable'); // Seleciona todas as tabelas

        tables.forEach(table => {
            const rows = table.querySelectorAll('thead tr'); // Seleciona todas as linhas da tabela
            let hasMatchingRows = false; // Flag para verificar se há linhas correspondentes à pesquisa

            rows.forEach(row => {
                const nomeContato = row.querySelector('th:nth-child(1)') ? row.querySelector('th:nth-child(1)').textContent.trim().toLowerCase() : ""; // Obtém o nome na primeira coluna

                // Se o nome da linha corresponder ao nome pesquisado, exibe a linha
                if (nomeContato.includes(nomePesquisaLower)) {
                    row.style.display = ''; // Exibe a linha
                    hasMatchingRows = true; // Marca que encontrou pelo menos uma linha correspondente
                } else {
                    row.style.display = 'none'; // Oculta a linha
                }
            });

            // Exibe ou oculta a tabela com base na correspondência de linhas
            if (hasMatchingRows) {
                table.style.display = ''; // Exibe a tabela se houver linhas correspondentes
            } else {
                table.style.display = 'none'; // Oculta a tabela se não houver linhas correspondentes
            }
        });
    }

    // Função para exibir todos os contatos (reset)
    const resetButton = document.getElementById('resetFilter');
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            mostrarTodosContatos(); // Exibe todos os contatos
        });
    }

    // Exibe todas as linhas
    function mostrarTodosContatos() {
        const tables = document.querySelectorAll('.containerTable');
        tables.forEach(table => {
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = ''; // Exibe todas as linhas
            });
            table.style.display = ''; // Exibe a tabela
        });
    }
});





document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.btnPosts');
    const resetButton = document.getElementById('resetFilter');
    
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove a classe 'active' de todos os botões
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Adiciona a classe 'active' ao botão clicado
            this.classList.add('active');
        });
    });

    // Adiciona evento para o botão de reset
    resetButton.addEventListener('click', function() {
        // Remove a classe 'active' de todos os botões
        buttons.forEach(btn => btn.classList.remove('active'));
    });
});




 
</script>
<script src="{{ asset('sweetalerta/app-sweetalert.js') }}"></script>
    <script src="{{ asset('sweetalerta/sweetalert2.all.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jvectormap/2.0.5/jquery-jvectormap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.9.1/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
    <script src="{{ asset('public/plugins/sparklines/sparkline.js') }}"></script>

@endsection
