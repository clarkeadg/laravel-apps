<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::createMaterializedView(
            'twitter_users',
            DB::table('users')
                ->select('name'),

            // Reaction::where('object_id', $this->id)
            // ->where('name', 'follow')
            // ->where('object_type', 'App\Models\User')
            // ->count();

            withData: false
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
