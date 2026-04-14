<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentation_material_types', function (Blueprint $table) {
            $table->id();
            $table->string('presentation_quantity');
            $table->foreignId('presentation_id')->constrained('presentations')->cascadeOnDelete();
            $table->foreignId('material_type_id')->constrained('material_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentation_material_types');
    }
};
