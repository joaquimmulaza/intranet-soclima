<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Feriado;

class Feria extends Model
{
    protected $table = 'ferias'; // Define a tabela associada
    protected $fillable = ['user_id', 'responsavel_id', 'data_inicio', 'data_fim', 'status']; // Campos permitidos para inserção

   

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Definindo o relacionamento com o responsável
    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function diasSolicitados($dataInicio, $dataFim)
    {
        $dataInicio = Carbon::parse($dataInicio);
        $dataFim = Carbon::parse($dataFim);

        
        
        // Calcular a diferença de dias úteis entre dataInicio e dataFim
        $diasSolicitados = 0;
        $feriados = Feriado::pluck('data')->toArray(); // Obter feriados cadastrados
        
        // Loop para contar os dias úteis
        while ($dataInicio->lte($dataFim)) {
            if ($dataInicio->isWeekend()) {
                // Log::warning("Data é fim de semana: " . $dataInicio->toDateString());
            } elseif (in_array($dataInicio->format('Y-m-d'), $feriados)) {
                Log::warning("Data é feriado: " . $dataInicio->toDateString());
            } else {
                $diasSolicitados++;
            }
            $dataInicio->addDay(); // Avançar para o próximo dia
        }
       
    
        return $diasSolicitados;
    }

    public function calcularDataRetorno($dataInicio, $diasSolicitados) {
        // Garantir que $diasSolicitados seja um número inteiro
        $diasSolicitados = (int) $diasSolicitados;
    
        $data = Carbon::parse($dataInicio);
        $feriados = Feriado::pluck('data')->toArray();
    
        $diasUteisContados = 0;
    
        while ($diasUteisContados < $diasSolicitados) {
            $data->addDay();
    
            if (!$data->isWeekend() && !in_array($data->format('Y-m-d'), $feriados)) {
                $diasUteisContados++;
            }
        }
    
        // Depois de contar os dias úteis, avançar até o próximo dia útil após o último dia de férias
        while ($data->isWeekend() || in_array($data->format('Y-m-d'), $feriados)) {
            $data->addDay();
        }
    
        // Retorna a data de retorno em formato 'Y-m-d'
        return $data->format('Y-m-d');
    }
     
    
}
