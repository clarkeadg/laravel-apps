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
        Schema::create('list_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('list_id')->unsigned();            
            $table->string('object_type');
            $table->integer('object_id')->unsigned();
            $table->integer('order')->unsigned();
            $table->timestamps();
        });

        Schema::table('list_items', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('list_id');
            $table->index('object_type');
            $table->index('object_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_items');
    }
};
