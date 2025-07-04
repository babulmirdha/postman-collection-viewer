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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('path')->unique();
            $table->text('data')->nullable();
            $table->string('type')->default('postman_collection');
            $table->string('version')->default('2.1.0');
            $table->string('description')->nullable();

            $table->foreignId('environment_id')->nullable()->constrained('environments')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
