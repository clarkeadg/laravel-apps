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
        Schema::create('video_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->nullable()->constrained('videos')->onUpdate('SET NULL')->onDelete('CASCADE');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onUpdate('SET NULL')->onDelete('CASCADE');
            $table->timestamps();
        });

        Schema::table('video_category', function(Blueprint $table) {
            $table->index('video_id');
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_category');
    }
};
