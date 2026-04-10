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
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('serial')->default(0)->after('description');
            $table->integer('homepage_serial')->nullable()->after('serial');
            $table->boolean('is_homepage')->default(false)->after('homepage_serial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['serial', 'homepage_serial', 'is_homepage']);
        });
    }
};
