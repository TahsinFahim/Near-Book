<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('name');
            $table->string('slug')->unique();

            // Optional Details
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();

            // Media
            $table->string('photo')->nullable();

            // Bio
            $table->text('short_bio')->nullable();
            $table->longText('biography')->nullable();

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
        Schema::dropIfExists('authors');
    }
};
