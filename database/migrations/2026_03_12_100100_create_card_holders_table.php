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
        Schema::create('card_holders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('card_id')->nullable()->constrained('cards')->cascadeOnDelete();
            $table->string('nomor_identitas')->nullable();
            $table->string('nama_pemegang')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('instansi')->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->string('foto')->nullable();
            $table->string('uuid')->nullable()->unique();
            $table->string('uuid_val')->nullable()->unique();
            $table->string('qrcode_val')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_holders');
    }
};
