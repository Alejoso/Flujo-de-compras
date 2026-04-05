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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['Tecnico', 'Tecnico Editada', 'Pendiente', 'Admin Editada', 'En Proceso', 'Facturada', 'Cancelada'])->default('Tecnico');
            $table->foreignId('proyectoId')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('creadoPor')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
