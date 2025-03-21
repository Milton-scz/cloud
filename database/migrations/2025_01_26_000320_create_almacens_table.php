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
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del almacén.
            $table->string('direccion'); // Dirección del almacén.
            $table->integer('capacidad'); // Capacidad en unidades.
            $table->text('descripcion')->nullable(); // Descripción opcional.
            $table->timestamps(); // Timestamps para created_at y updated_at.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacens');
    }
};
