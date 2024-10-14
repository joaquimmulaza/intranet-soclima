<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('numero_mecanografico')->nullable()->after('id');
            $table->string('numero_bi')->nullable()->after('numero_mecanografico');
            $table->string('numero_beneficiario')->nullable()->after('numero_bi');
            $table->string('numero_contribuinte')->nullable()->after('numero_beneficiario');
            $table->date('data_admissao')->nullable()->after('numero_contribuinte');
            $table->date('data_emissao_bi')->nullable()->after('data_admissao');
            $table->date('data_validade_bi')->nullable()->after('data_emissao_bi');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'numero_mecanografico',
                'numero_bi',
                'numero_beneficiario',
                'numero_contribuinte',
                'data_admissao',
                'data_emissao_bi',
                'data_validade_bi',
            ]);
        });
    }
}
