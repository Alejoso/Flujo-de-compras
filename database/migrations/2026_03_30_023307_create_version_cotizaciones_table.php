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
        Schema::create('version_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numeroVersion');
            $table->boolean('esLaMasReciente')->default(true);
            $table->foreignId('cotizacionId')->constrained('cotizaciones')->cascadeOnDelete();
            $table->string('pdfPath')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('version_cotizaciones');
    }
};
