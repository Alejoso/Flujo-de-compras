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
        Schema::create('presentacion_tipo_material_version_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->double('cantidad');
            $table->foreignId('versionCotizacionId')->constrained('version_cotizaciones')->cascadeOnDelete();
            $table->foreignId('presentacionTipoMaterialId')->constrained('presentacion_tipo_materiales')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentacion_tipo_material_version_cotizaciones');
    }
};
