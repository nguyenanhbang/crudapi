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
        Schema::table('users', function (Blueprint $table){
            $table->foreignId('deparment_id')->constrained('users');
            $table->foreignId('status_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropForeign('users_deparment_id_foreign');
            $table->dropForeign('users_status_id_foreign');

            $table->dropColumn(['deparment_id', 'status_id']);
        });
    }
};
