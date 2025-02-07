<?php
namespace App\Imports;

use App\DiasFerias;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log; 
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FeriasImport implements ToModel, WithCalculatedFormulas, WithStartRow
{
    private $anoFerias; // Variável para armazenar o ano das férias

    public function __construct()
    {
        $this->anoFerias = null; // Inicializa sem um ano definido
    }

    public function model(array $row)
    {
        // Se for a primeira linha (cabeçalho), extrai o ano do título da coluna
        if (!$this->anoFerias && isset($row[1])) {
            $this->anoFerias = $this->extrairAnoFerias($row[1]);
            Log::info("Ano extraído do cabeçalho: " . $this->anoFerias);
            return null; // Ignora a linha do cabeçalho
        }

        // Se ainda não encontrou o ano, não processa
        if (!$this->anoFerias) {
            Log::error("Erro: Não foi possível extrair o ano das férias.");
            return null;
        }

        // Obtém o número mecanográfico do usuário
        $numeroMecanografico = $row[0];

        // Verifica se o usuário existe
        $user = User::where('numero_mecanografico', $numeroMecanografico)->first();
        if (!$user) {
            Log::warning("Usuário não encontrado para o número mecanográfico: " . $numeroMecanografico);
            return null;
        }

        // Obtém os dias disponíveis da coluna 1 (que contém os valores)
        $diasDisponiveis = preg_replace('/[^0-9]/', '', $row[1]);

        if (!$diasDisponiveis) {
            Log::error("Erro: Dias disponíveis inválidos para $numeroMecanografico no ano {$this->anoFerias}");
            return null;
        }

        // Verifica se já existe um registro para esse usuário e ano
        $diasFerias = DiasFerias::where('user_id', $user->id)
                                ->where('ano', $this->anoFerias)
                                ->first();

        if ($diasFerias) {
            $diasFerias->dias_disponiveis = $diasDisponiveis;
            $diasFerias->save();
        } else {
            return new DiasFerias([
                'user_id' => $user->id,
                'ano' => $this->anoFerias,
                'dias_disponiveis' => $diasDisponiveis,
            ]);
        }
    }

    // Define a linha inicial como 1 para pegar o cabeçalho primeiro
    public function startRow(): int
    {
        return 1;
    }

    // Função para extrair o ano do título da coluna
    private function extrairAnoFerias($titulo)
    {
        preg_match('/\d{4}/', $titulo, $matches);
        return $matches[0] ?? null;
    }
}
