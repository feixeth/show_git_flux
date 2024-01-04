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

        // Add the foreign key constraint 
        Schema::table('gitfeed', function (Blueprint $table) {
            $table->foreignId('key_couple_id')->constrained('key_couples');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gitfeed', function (Blueprint $table) {
            $table->dropForeign(['key_couple_id']);
            $table->dropColumn('key_couple_id');
        });
    }
};
