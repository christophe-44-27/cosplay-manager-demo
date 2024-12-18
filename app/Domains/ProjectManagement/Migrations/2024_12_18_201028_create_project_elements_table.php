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
        Schema::create('project_elements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('price')->nullable();
            $table->boolean('is_done')->default(false);
            $table->boolean('to_make')->default(true);
            $table->string('thumbnail')->nullable();
            $table->foreignId('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_elements');
    }
};
