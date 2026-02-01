<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('top_navbar', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();     // key (order_track)
            $table->string('label');              // visible text (Bangla)
            $table->string('url');                // link (/order-track)

            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0); // ordering

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('top_navbar');
    }
};
