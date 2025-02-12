<?php

use App\Models\Almacen;
use App\Models\Proveedor;
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
        Schema::create('nota_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Proveedor::class);
            $table->string('fecha');
            $table->string('glosa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_compras');
    }
};
