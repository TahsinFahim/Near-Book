<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id(); // Auto-increment primary key
        $table->string('name'); // Category name
        $table->string('slug')->unique(); // SEO-friendly URL
        $table->text('description')->nullable(); // Optional description
        $table->boolean('is_active')->default(true); // Visibility status
        $table->timestamps(); // created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
