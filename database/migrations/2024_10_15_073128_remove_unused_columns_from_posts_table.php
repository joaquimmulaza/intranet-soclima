<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedColumnsFromPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropColumn(['resumo', 'validate_at', 'capa', 'subtitle']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            Schema::table('posts', function (Blueprint $table) {
                $table->string('resumo')->nullable();
                $table->date('validate_at')->nullable();
                $table->string('capa')->nullabe();
            });
        });
    }
}
