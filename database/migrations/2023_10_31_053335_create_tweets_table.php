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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('content');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('repost_id')->unsigned()->nullable();
            $table->boolean('sensitive')->nullable();
            $table->timestamps();
        });

        Schema::table('tweets', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('repost_id');
            $table->index('sensitive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
