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
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('name'); // Department name
            $table->string('code')->unique(); // Department code, e.g., CSE, EEE
            $table->string('faculty')->nullable(); // Faculty or school, e.g., Engineering
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
