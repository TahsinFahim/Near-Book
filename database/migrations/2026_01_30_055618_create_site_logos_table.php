<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_logos', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path'); // storage path of logo
            $table->string('alt_text')->nullable(); // optional
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_logos');
    }
};
