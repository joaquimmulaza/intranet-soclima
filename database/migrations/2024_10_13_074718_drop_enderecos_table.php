<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropEnderecosTable extends Migration
{
 
    public function up()
    {
        //
        Schema::dropIfExists('enderecos');
    }

    public function down()
    {
        //
        Schema::create('enderecos', function (Blueprint $table){
            $table->id();
            $table->timestamps();
        });
    }
}
