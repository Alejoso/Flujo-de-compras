<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentacion_tipo_materiales', function (Blueprint $table) {
            $table->id();
            $table->string('cantidadPresentacion');
            $table->foreignId('presentacionId')->constrained('presentaciones')->cascadeOnDelete();
            $table->foreignId('tipoMaterialId')->constrained('tipo_materiales')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentacion_tipo_materiales');
    }
};
