<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use App\Models\Producto;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfertaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $productos = Producto::with('categoria')
        ->where('isOferta', 1)
        ->get();


        return Inertia::render('GestionarInventario/Ofertas/index', [
            'productos' => $productos,

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         // Obtener solo los productos en oferta junto con sus categorías
         $productos = Producto::with('categoria')
         ->where('isOferta', 0)
         ->get();


         return Inertia::render('GestionarInventario/Ofertas/create', [
             'productos' => $productos,


         ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Oferta $oferta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oferta $oferta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $producto_id)
    {
        $request->validate([
            'porcentaje' => 'required|numeric|min:0|max:100',
        ]);

        $producto = Producto::find($producto_id);
        if (!$producto) {
            return redirect()->route('admin.ofertas')->with('error', 'El producto no existe.');
        }

        $producto->isOferta = 1;
        $producto->descuento = $request->porcentaje;
        $producto->save();

        return redirect()->route('admin.ofertas')->with('success', 'El descuento se aplicó correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($producto_id)
    {
        $producto = Producto::find($producto_id);
        $producto->isOferta = 0;
        $producto->descuento = 0;
        $producto->save();
        return redirect()->route('admin.ofertas');
    }
}
