<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('roleid');
            $table->string('role_name')->unique();
            $table->string('description')->nullable();
            $table->integer('isactive')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('created_by');
            $table->string('created_by_ip');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_ip')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
