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
                <td style="padding: 0; margin: 0;">
                    <span style="color: #009AC1;">{{ $telefone->telefone }}</span>
                </td>
                <td style="padding: 0; margin: 0;">
                    <span style="color: #009AC1;">{{ $telefone->email }}</span>
                </td>
            </tr>
        </tbody>
    </table>
@endforeach
