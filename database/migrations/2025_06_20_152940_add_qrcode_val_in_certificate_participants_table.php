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
        Schema::table('certificate_participants', function (Blueprint $table) {
            $table->string('qrcode_val')->after('uuid_val')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificate_participants', function (Blueprint $table) {
            $table->dropColumn('qrcode_val');
        });
    }
};
