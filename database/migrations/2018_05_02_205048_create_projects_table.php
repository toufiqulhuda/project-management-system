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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('project_id');
            $table->string('title')->unique();
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('start_at')->nullable();
            $table->string('end_at')->nullable();
            $table->integer('status')->default(0);
            $table->double('cost')->nullable();
            $table->double('assigned_to')->nullable();
            $table->double('assigned_at')->nullable();
            $table->double('assigned_by')->nullable();
            $table->double('assigned_by_ip')->nullable();
            $table->integer('isactive')->default(0);
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
        Schema::dropIfExists('projects');
    }
};
