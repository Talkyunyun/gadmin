<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGhUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gh_users', function(Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->charset= 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->increments('id');
            $table->string('username', 50)->nullable();
            $table->char('password', 40)->nullable();
            $table->tinyInteger('status', 1)->unsigned()->default(1)->comment('状态,1:正常,0:禁用');
            $table->integer('created_at')->unsigned()->comment('添加时间');
            $table->integer('updated_at')->unsigned()->comment('修改时间');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
