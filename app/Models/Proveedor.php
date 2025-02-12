<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $guarded=[];

    public function notasCompras()
    {
        return $this->belongsToMany(NotaCompra::class);
    }
}
