<?php

use App\Models\Categoria;  // Asegúrate de importar la clase Categoria
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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('stock')->default(0);
            $table->decimal('precio', 8, 2);
            $table->foreignIdFor(Categoria::class);
            $table->string('imagen')->nullable();
            $table->string('descripcion');
            $table->integer('isOferta')->default(0);
            $table->integer('descuento')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
