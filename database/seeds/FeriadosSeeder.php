<?php

// database/seeders/FeriadosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeriadosSeeder extends Seeder
{
    public function run()
    {
        $feriados = [
            ['data' => Carbon::parse('2025-01-01'), 'descricao' => 'Ano Novo'],
            ['data' => Carbon::parse('2025-02-03'), 'descricao' => 'Feriado do Dia Nacional do Esforço Armado'],
            ['data' => Carbon::parse('2025-02-04'), 'descricao' => 'Dia Nacional do Esforço Armado'],
            ['data' => Carbon::parse('2025-03-03'), 'descricao' => 'Feriado do Carnaval'],
            ['data' => Carbon::parse('2025-03-04'), 'descricao' => 'Carnaval'],
            ['data' => Carbon::parse('2025-03-08'), 'descricao' => 'Dia Internacional da Mulher'],
            ['data' => Carbon::parse('2025-03-23'), 'descricao' => 'Dia da Batalha do Cuito Cuanavale'],
            ['data' => Carbon::parse('2025-04-04'), 'descricao' => 'Dia da Paz'],
            ['data' => Carbon::parse('2025-04-18'), 'descricao' => 'Sexta-Feira Santa'],
            ['data' => Carbon::parse('2025-05-01'), 'descricao' => 'Dia do Trabalhador'],
            ['data' => Carbon::parse('2025-05-02'), 'descricao' => 'Feriado do Dia do Trabalhador'],
            ['data' => Carbon::parse('2025-09-17'), 'descricao' => 'Dia dos Heróis Nacionais'],
            ['data' => Carbon::parse('2025-11-02'), 'descricao' => 'Dia de Finados'],
            ['data' => Carbon::parse('2025-11-10'), 'descricao' => 'Feriado do Dia da Independência'],
            ['data' => Carbon::parse('2025-11-11'), 'descricao' => 'Dia da Independência'],
            ['data' => Carbon::parse('2025-12-25'), 'descricao' => 'Natal'],
            ['data' => Carbon::parse('2025-12-26'), 'descricao' => 'Feriado do Natal'],
        ];

        DB::table('feriados')->insert($feriados);
    }
}
