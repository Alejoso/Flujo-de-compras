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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('ciudad');
            $table->double('costoTotal')->nullable();
            $table->enum('estado', ['En Negociación', 'En Ejecución', 'Finalizado'])->default('En Negociación');
            $table->foreignId('clienteId')->constrained('clientes')->restrictOnDelete();
            $table->foreignId('creadoPor')->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
