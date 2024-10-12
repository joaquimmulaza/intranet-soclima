/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA DELETAR QUESTÃO DO FORMULÁRIO
 |--------------------------------------------------------------------------*/
function questionData(id) {
    swal({
        title: 'Deseja mesmo fazer isso?',
        text: "A questão e opções serão excluidas permanentemente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Deletar!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('question-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA DELETAR OBJETOS CRIADOS NO SISTEMA
 |--------------------------------------------------------------------------*/
 function deleteData(id) {
    swal({
        title: 'Deseja mesmo fazer isso?',
        text: "Você não poderá reverter isto novamente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Deletar!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA DELETAR USUÁRIO E COMENTÁRIOS
 |--------------------------------------------------------------------------*/
function deleteDataUser(id) {
    swal({
        title: 'Deseja mesmo fazer isso?',
        text: "Todos comentários deste usuário serão excluidos permanentemente!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Deletar!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('delete-user-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA BLOQUEAR USUÁRIO
 |--------------------------------------------------------------------------*/
function bloqueaData(id) {
    swal({
        title: 'Bloquear pedido?',
        text: "Você poderá reverter futuramente esta ação depois!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Bloquear!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('bloq-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA FINALIZAR CRIAÇÃO DO QUESTIONÁRIO/ENQUETE
 |--------------------------------------------------------------------------*/
function finalizaQuestData(id) {
    swal({
        title: 'Finalizar questionário?',
        text: "Ao finalizar o questionário, os usuários poderam responder!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Finalizar!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('quest-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1. FUNÇÃO PARA LIBERAR ENTRADA DE USUÁRIO NOVO
 |--------------------------------------------------------------------------*/
function liberaData(id) {
    swal({
        title: 'Deseja realmente liberar este usuário?',
        text: "Ele terá acesso ao sistema conforme seu nivel!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00C851',
        cancelButtonColor: '#ff4444',
        confirmButtonText: 'Sim, Liberar!'
    }).then((result) => {
        if (result.value) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

/*Annotation: ---------------------------------------------------------------
 |1.
 |--------------------------------------------------------------------------*/
function defaultData(id) {
    swal({
        title: 'Este usuário já esta bloqueado!',
        text: "Você pode liberar este usuário!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#ff4444',
    }).then((result) => {
        if (result.value) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

