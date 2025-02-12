<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nota_compra_id',
        'producto_id',     // Asegúrate de incluir este campo
        'cantidad',
        'precio',
    ];

    // Relación con NotaCompra (opcional, si existe)
    public function notaCompra()
    {
        return $this->belongsTo(NotaCompra::class);
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
