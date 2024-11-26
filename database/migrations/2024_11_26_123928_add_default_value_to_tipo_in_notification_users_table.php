<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToTipoInNotificationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `notification_users` MODIFY COLUMN `tipo` VARCHAR(255) DEFAULT 'default_value'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE `notification_users` MODIFY COLUMN `tipo` VARCHAR(255) DEFAULT NULL");
    }
}
