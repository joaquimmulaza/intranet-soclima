@extends('master.layout')

@section('content')
<div class="content-header header-crumb">
    <div class="container-fluid">
        <div class="row mb-2 justify-content-between">
            <div class="">
                <ol class="breadcrumb float-sm-right">
                    <!-- <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> -->
                    <li class="breadcrumb-item active">Ausências</li>
                </ol>
            </div>

            <div class="changePageBtn">
                <a href="#" class="ChangeBtnFaltas" id="btnFaltas">Faltas</a>
                <a href="#" class="ChangeBtnFerias" id="btnFerias">Férias</a>
            </div>
        </div>
    </div>
    <hr>
</div>

<div class="main_container manager_doc">
    <span>Nenhum pedido de féria</span>
    <a href="#">Gerenciar</a>
</div>

<div class="container_calendar">
    <!-- Exibindo o calendário -->
    <div id="calendar"></div>
</div>

<!-- Incluindo o FullCalendar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/locale/pt.js"></script>


<script>
    $(document).ready(function() {
    let eventCountByDate = {}; // Objeto para contar quantos eventos já ocorreram em um determinado dia

    // Função para gerar cores alternadas para eventos no mesmo dia
    function generateAlternatingHexColor(date, index) {
        // Gerar cor base de forma similar ao código anterior
        const baseHash = (date.getTime() + index);
        const hexColor = "#" + ((baseHash & 0x00FFFFFF) | 0x808080).toString(16).padStart(6, '0');
        return hexColor;
    }

    $('#calendar').fullCalendar({
        locale: 'pt', // Define o idioma como português
        events: '/events',  // URL que retorna os eventos (pedidos de férias)
        editable: false,  // Desabilitar edição
        droppable: false,  // Não permitir arrastar eventos
        eventRender: function(event, element) {
            element.find('.fc-title').append('<br/>' + event.description);  // Exibe descrição do evento

            // Extraímos a data de início e a data de fim do evento
            const startDate = new Date(event.start);
            const endDate = event.end ? new Date(event.end) : startDate;

            // Criamos um identificador único para o dia (usando data de início e fim)
            let eventKey = startDate.toISOString().split('T')[0]; // Usa a data no formato YYYY-MM-DD como chave
            if (!eventCountByDate[eventKey]) {
                eventCountByDate[eventKey] = 0; // Se não houver eventos no mesmo dia, inicia o contador
            }

            // Alterna a cor para cada evento no mesmo dia
            const color = generateAlternatingHexColor(startDate, eventCountByDate[eventKey]);
            
            // Atribui a cor de fundo ao evento
            element.css('background-color', color);
            element.css('border-color', color);

            // Incrementa o contador para o dia
            eventCountByDate[eventKey]++;
        },
    });
});

</script>
@endsection