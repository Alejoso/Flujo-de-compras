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
        Schema::create('unidad_medida_cantidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cantidadId')->constrained('cantidades')->cascadeOnDelete();
            $table->foreignId('unidadMedidaId')->constrained('unidad_medidas')->cascadeOnDelete();
            $table->foreignId('tipoId')->constrained('tipos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_medida_cantidades');
    }
};
