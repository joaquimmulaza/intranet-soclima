<?php

use App\Cargo;
use App\Unidade;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {

        Cargo::updateOrCreate([
            'titulo'=> 'Gerente',
            'atividades'=> 'Manter o controle e planejamento de partes da empresa.'
        ]);

        Cargo::updateOrCreate([
                'titulo'=> 'Auxiliar',
                'atividades'=> 'Realizar controle, limpeza e manter as BPFs.'
            ]);


        Unidade::updateOrCreate([
            'titulo'=> 'Matriz',
            'descricao'=> 'Industrial e desenvolvimento.'
        ]);

        User::updateOrCreate([
            'role_id'=> Role::where('slug', 'admininstrador')->first()->id,
            'cargo_id'=> Cargo::where('titulo', 'Gerente')->first()->id,
            'unidade_id'=> Unidade::where('titulo', 'Matriz')->first()->id,
            'name'=> 'Admin RH',
            'email'=> 'Rafaelblum_digital@hotmail.com',
            'status'=> 'ativo',
            'password'=> Hash::make('123'),
        ]);

        User::updateOrCreate([
            'role_id'=> Role::where('slug', 'usuario')->first()->id,
            'cargo_id'=> Cargo::where('titulo', 'Auxiliar')->first()->id,
            'unidade_id'=> Unidade::where('titulo', 'Matriz')->first()->id,
            'name'=> 'User',
            'email'=> 'user@hotmail.com',
            'status'=> 'ativo',
            'password'=> Hash::make('123'),
        ]);

        //CRIAR ENDERE�O AQUI....

    }
}
