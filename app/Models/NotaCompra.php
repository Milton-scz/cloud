<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function detalleCompras(){
        return $this->hasMany(DetalleCompra::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function productos()
{
    return $this->belongsToMany(Producto::class, 'detalle_compras')
                ->withPivot('cantidad')
                ->withTimestamps();
}

}
