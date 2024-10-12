<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * CHAMADA DAS SEEDERS
     * CRIAÇÃO DAS ENTIDADES AO INICIAR O PROJETO
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
