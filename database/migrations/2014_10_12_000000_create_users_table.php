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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('images')->nullable();
            $table->string('country')->nullable();
            $table->integer('type');
            $table->integer('isactive')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->integer('created_by');
            $table->string('created_by_ip');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_ip')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
