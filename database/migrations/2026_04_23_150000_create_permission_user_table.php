<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('permission_user')) {
            return;
        }

        Schema::create('permission_user', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('user_type');

            $table->primary(['permission_id', 'user_id', 'user_type']);
            $table->index(['user_id', 'user_type'], 'permission_user_user_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_user');
    }
}

