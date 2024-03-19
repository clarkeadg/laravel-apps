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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('profile_id')->unsigned();
            $table->string('object_type')->nullable();
            $table->integer('object_id')->unsigned()->nullable();
            $table->string('content')->nullable();
            $table->timestamps();
        });

        Schema::table('reports', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('profile_id');
            $table->index('object_type');
            $table->index('object_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
