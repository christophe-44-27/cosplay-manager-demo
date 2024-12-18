<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cosflow_resources', function (Blueprint $table) {
            $table->id();
            $table->morphs('resourceable');
            $table->unsignedBigInteger('resource_type_id');
            $table->foreign('resource_type_id')->references('id')->on('cosflow_resource_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosflow_resources');
    }
};
