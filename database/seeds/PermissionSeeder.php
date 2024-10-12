<?php

use App\Module;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        $moduleAppDashboard = Module::updateOrCreate(['name'=>'Painel administrativo']);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppDashboard->id,
            'name'=> 'Acesso administrativo',
            'slug'=> 'app.dashboard'
        ]);

        $moduleAppRole = Module::updateOrCreate(['name'=>'Administrar permissões']);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppRole->id,
            'name'=> 'Accesso a permissões',
            'slug'=> 'app.roles.index'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppRole->id,
            'name'=> 'Criar permissão',
            'slug'=> 'app.roles.create'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppRole->id,
            'name'=> 'Editar permissão',
            'slug'=> 'app.roles.edit'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppRole->id,
            'name'=> 'Deletar permissão',
            'slug'=> 'app.roles.destroy'
        ]);



        $moduleAppUser = Module::updateOrCreate(['name'=>'Administrar usuários']);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppUser->id,
            'name'=> 'Acesso a usuários',
            'slug'=> 'app.users.index'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppUser->id,
            'name'=> 'Criar usuário',
            'slug'=> 'app.users.create'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppUser->id,
            'name'=> 'Editar usuário',
            'slug'=> 'app.users.edit'
        ]);

        Permission::updateOrCreate([
            'module_id'=> $moduleAppUser->id,
            'name'=> 'Deletar usuário',
            'slug'=> 'app.users.destroy'
        ]);
    }
}
