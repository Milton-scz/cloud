<?php

use App\Models\Almacen;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
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
        Schema::create('ajuste_inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Producto::class);
            $table->foreignIdFor(Almacen::class);
            $table->integer('cantidad');
            $table->integer('tipo');
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuste_inventarios');
    }
};
