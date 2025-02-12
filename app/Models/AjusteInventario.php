<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'almacen_id',
        'cantidad',
        'tipo',
        'descripcion',
    ];

    public function ProductoAlmacen()
    {
        return $this->belongsTo(ProductoAlmacen::class);
    }

   // En el modelo AjusteInventario
public function producto()
{
    return $this->belongsTo(Producto::class, 'producto_id');
}

public function almacen()
{
    return $this->belongsTo(Almacen::class, 'almacen_id');
}
}
