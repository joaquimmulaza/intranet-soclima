<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeriadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('feriados')->insert([
        ['data' => '2024-01-01','descricao'=> 'Ano Novo', 'fim_semana_prolongado' => true],
        ['data' => '2024-02-04','descricao'=> 'Dia do Movimento de Libertação', 'fim_semana_prolongado' => false],
        ['data' => '2024-02-05','descricao'=> 'Dia do Movimento de Libertação', 'fim_semana_prolongado' => true],
        ['data' => '2024-02-13','descricao'=> 'Carnaval', 'fim_semana_prolongado' => false],
        ['data' => '2024-03-08','descricao'=> 'Dia Internacional da Mulher', 'fim_semana_prolongado' => true],
        ['data' => '2024-03-23','descricao'=> 'Dia da Libertação da África Austral', 'fim_semana_prolongado' => false],
        ['data' => '2024-03-29','descricao'=> 'Sexta-feira Santa', 'fim_semana_prolongado' => true],
        ['data' => '2024-04-04','descricao'=> 'Dia da Paz', 'fim_semana_prolongado' => false],
        ['data' => '2024-04-05','descricao'=> 'Dia da Paz', 'fim_semana_prolongado' => true],
        ['data' => '2024-05-01','descricao'=> 'Dia do Trabalhador', 'fim_semana_prolongado' => false],
        ['data' => '2024-09-16','descricao'=> 'Dia do Herói Nacional', 'fim_semana_prolongado' => true],
        ['data' => '2024-09-17','descricao'=> 'Dia do Herói Nacional', 'fim_semana_prolongado' => false],
        ['data' => '2024-11-02','descricao'=> 'Dia dos Finados', 'fim_semana_prolongado' => false],
        ['data' => '2024-11-11','descricao'=> 'Dia da Independência', 'fim_semana_prolongado' => true],
        ['data' => '2024-12-25','descricao'=> 'Dia de Natal', 'fim_semana_prolongado' => false],
        ]);
    }
}