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
        Schema::create('presentation_material_type_quotation_versions', function (Blueprint $table) {
            $table->id();
            $table->double('quantity');
            $table->foreignId('quotation_version_id')->constrained('quotation_versions')->cascadeOnDelete();
            $table->foreignId('presentation_material_type_id')->constrained('presentation_material_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_material_type_quotation_versions');
    }
};
