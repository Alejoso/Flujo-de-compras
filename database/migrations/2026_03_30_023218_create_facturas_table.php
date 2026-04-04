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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('valorTotal');
            $table->enum('estado', ['Pendiente', 'Aprobada', 'Rechazada', 'Pagada', 'Cancelada']);
            $table->foreignId('proyectoId')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('proveedorId')->constrained('proveedores')->cascadeOnDelete();
            $table->foreignId('cotizacionId')->constrained('cotizaciones')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
