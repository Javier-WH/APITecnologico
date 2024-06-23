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
        Schema::create('api_user_info', function (Blueprint $table) {
            $table->id()->primary()->autoIncrement();
            $table->uuid('user_id')->nullable(false)->unique();
            $table->string('first_name', 50)->nullable(false);
            $table->string('last_name', 50)->nullable(false);
            $table->string('ci', 50)->nullable(false);
            $table->string('phone', 50)->nullable(false);
            $table->string('email', 50)->nullable(false)->unique();
            $table->string('address', 50)->nullable(false);
            $table->string('description', 200)->nullable(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('api_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_user_info');
    }
};
