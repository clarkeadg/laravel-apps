<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createFunction(
            name: 'refresh_twitter_users',
            parameters: [],
            return: 'trigger',
            language: 'plpgsql',
            body: '
              BEGIN
                REFRESH MATERIALIZED VIEW twitter_users;
                RETURN NULL;
              END;
            '
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
