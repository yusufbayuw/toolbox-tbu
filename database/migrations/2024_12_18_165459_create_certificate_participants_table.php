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
        Schema::create('certificate_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->nullable()->constrained('certificates')->cascadeOnDelete();
            $table->integer('nomor')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('asal_penerima')->nullable();
            $table->string('uuid')->nullable()->unique();
            $table->string('uuid_val')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_participants');
    }
};
