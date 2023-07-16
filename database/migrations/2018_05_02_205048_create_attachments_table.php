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
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->unique();
            $table->string('file_path');
            $table->integer('project_id');
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
        Schema::dropIfExists('attachments');
    }
};
