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
        Schema::create('quotation_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version_number');
            $table->boolean('is_most_recent')->default(true);
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_versions');
    }
};
