<?php

use App\Models\Almacen;
use App\Models\Producto;
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
        Schema::create('producto_almacens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Producto::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Almacen::class)->constrained()->onDelete('cascade');;
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_almacens');
    }
};
