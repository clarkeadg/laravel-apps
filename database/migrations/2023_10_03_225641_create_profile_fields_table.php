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
        Schema::create('profile_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('profile_group_id')->unsigned();
            $table->string('type');
            $table->string('name');
            $table->string('title');
            $table->string('placeholder')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('field_order')->default(0);
            $table->json('options')->nullable();
            $table->timestamps();
        });

        Schema::table('profile_fields', function(Blueprint $table) {
            $table->index('profile_group_id');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_fields');
    }
};
