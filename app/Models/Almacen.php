<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_almacens')
                    ->withPivot('stock'); // Incluye el campo 'stock' de la tabla intermedia
    }
}
