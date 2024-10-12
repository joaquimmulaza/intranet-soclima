<?php

use Illuminate\Database\Seeder;
use\App\Permission;
use\App\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $adminPermissions = Permission::all();

        Role::updateOrCreate([
            'name' => 'admin',
            'slug' => 'admininstrador',
            'deletable' => false
        ])->permissions()->sync($adminPermissions->pluck('id'));

        Role::updateOrCreate([
            'name' => 'user',
            'slug' => 'usuario',
            'deletable' => false
        ]);
    }
}
