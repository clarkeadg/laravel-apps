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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->unsigned();
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('remote')->nullable();
            $table->string('type')->nullable();
            $table->string('benefits')->nullable();
            $table->string('compensation')->nullable();
            $table->longText('description');
            $table->string('source_url')->nullable();
            $table->dateTime('posted_date')->nullable();
            $table->timestamps();
        });

        Schema::table('jobs', function(Blueprint $table) {
            $table->index('company_id');
            $table->index('title');
            $table->index('location');
            $table->index('remote');
            $table->index('type');
            $table->index('benefits');
            $table->index('compensation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
