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

    public function diasSolicitados() {
        $dataInicio = Carbon::parse($this->data_inicio);
        $dataFim = Carbon::parse($this->data_fim);
    
        // Calcular a diferença de dias, desconsiderando finais de semana e feriados
        $diasSolicitados = 0;
        $feriados = Feriado::pluck('data')->toArray(); // Obter feriados
    
        while ($dataInicio->lt($dataFim)) {
            if (!$dataInicio->isWeekend() && !in_array($dataInicio->format('Y-m-d'), $feriados)) {
                $diasSolicitados++;
            }
            $dataInicio->addDay();
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
