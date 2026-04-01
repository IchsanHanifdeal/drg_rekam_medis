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
        Schema::create('tindakan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran');
            $table->foreign('pendaftaran')->references('id')->on('pendaftaran')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('biaya');
            $table->string('tensi_darah')->nullable();
            $table->string('berat_badan')->nullable();
            $table->integer('tooth_number')->nullable();
            $table->unsignedBigInteger('opsi_tindakan');
            $table->foreign('opsi_tindakan')->references('id')->on('opsi_tindakan')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindakan');
    }
};
