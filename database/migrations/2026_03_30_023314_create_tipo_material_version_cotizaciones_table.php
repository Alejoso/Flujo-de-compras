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
        Schema::create('tipo_material_version_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->float('cantidad');
            $table->foreignId('version_cotizacion_id')->constrained('version_cotizaciones')->cascadeOnDelete();
            $table->foreignId('tipo_material_id')->constrained('tipo_materiales')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_material_version_cotizaciones');
    }
};
