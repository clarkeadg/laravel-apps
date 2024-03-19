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
        Schema::create('search_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->json('options')->nullable();
            $table->timestamps();
        });

        Schema::table('search_forms', function(Blueprint $table) {
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_forms');
    }
};
