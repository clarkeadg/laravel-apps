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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('object_type')->nullable();
            $table->integer('object_id')->unsigned()->nullable();
            $table->string('subobject_type')->nullable();
            $table->integer('subobject_id')->unsigned()->nullable();
            $table->datetime('read')->nullable();
            $table->timestamps();            
        });

        Schema::table('notifications', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('name');
            $table->index('read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
