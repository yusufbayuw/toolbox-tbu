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
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->cascadeOnDelete();
        });

        Schema::table('qrs', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Correct syntax
            $table->dropColumn('user_id');    // Remove the column as well
        });

        Schema::table('qrs', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Correct syntax
            $table->dropColumn('user_id');    // Remove the column as well
        });
    }
};
