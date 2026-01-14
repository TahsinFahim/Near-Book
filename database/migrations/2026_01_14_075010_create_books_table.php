<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->string('isbn')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('stock')->default(0);

            // Media
            $table->string('cover_image')->nullable();

            // Description
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Publication info
            $table->date('publication_date')->nullable();
            $table->string('publisher')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
