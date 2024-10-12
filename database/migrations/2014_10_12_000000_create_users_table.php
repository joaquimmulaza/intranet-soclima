<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('role_id');
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('unidade_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('status');
            $table->string('password');
            $table->timestamp('ultimo_acesso')->nullable();
            $table->timestamp('nascimento')->nullable();
            $table->string('state_civil')->nullable();
            $table->string('formacao')->nullable();
            $table->string('fone')->nullable();
            $table->integer('ramal')->nullable();
            $table->string('avatar')->default('default.jpg');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('CASCADE');
            //$table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('CASCADE');
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
