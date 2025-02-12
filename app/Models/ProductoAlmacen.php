<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoAlmacen extends Model
{
   // En el modelo ProductoAlmacen
public function producto()
{
    return $this->belongsTo(Producto::class);
}
public function AjustesInventarios()
{
    return $this->belongsToMany(AjusteInventario::class);
}
}
