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
    public function up(): void
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('group_id')->references('id')->on('groups');
            $table->boolean('is_pending')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
