<?php

namespace App\Http\Controllers;

use App\Http\Requests\Almacen\AlmacenStoreRequest;
use App\Http\Requests\AlmacenRequest;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\ProductoAlmacen;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlmacenController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = Almacen::paginate(10);
        return Inertia::render('GestionarInventario/Almacenes/index', [
            'almacenes' => $almacenes,

        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('GestionarInventario/Almacenes/create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlmacenRequest $request)
    {
        $validatedData = $request->validated();
        Almacen::create($validatedData);

        return redirect()->route('admin.almacenes')->with('success', 'Almacén creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function verProductos($almacen_id)
    {

        // Obtener los productos del almacén, incluyendo el nombre de los productos
        $productos = ProductoAlmacen::where('almacen_id', $almacen_id)
                                    ->with('producto') // Cargar la relación 'producto' que trae los datos del producto
                                    ->get();
//dd($productos);
        // Retornar la vista con los productos
        return Inertia::render('GestionarInventario/Almacenes/productos', [
            'productos' => $productos,

        ]);
    }



    public function agregarProducto($almacenId)
    {

        // Buscar el almacén
        $almacen = Almacen::findOrFail($almacenId);

        // Obtener todos los productos que NO están en el almacén específico
        $productos = Producto::whereDoesntHave('almacenes', function ($query) use ($almacenId) {
            $query->where('almacens.id', $almacenId);
        })->get();

        // Pasar los productos y el almacén a la vista
        return Inertia::render('GestionarInventario/Almacenes/agregarProducto', [
            'almacen' => $almacen,
            'productos' => $productos,

        ]);
    }


    public function agregarProductoAlmacen(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'stock' => 'required|integer|min:1',
            'almacen_id' => 'required|exists:almacens,id',
        ]);

        $almacen = Almacen::findOrFail($validated['almacen_id']);
        $producto = Producto::findOrFail($validated['producto_id']);

        // Asociar el producto al almacén (muchos a muchos)
        $almacen->productos()->attach($producto, ['stock' => $validated['stock']]);

        // Redirigir de vuelta con mensaje de éxito
        return redirect()->route('admin.almacenes.agregar-producto', $almacen->id)
                         ->with('success', 'Producto ' . $producto->nombre . ' agregado al almacén correctamente.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
    {

        return Inertia::render('GestionarInventario/Almacenes/edit', [
            'almacen' => $almacen,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlmacenRequest $request, Almacen $almacen)
    {
        $validatedData = $request->validated();
        $almacen->update($validatedData);

        return redirect()->route('admin.almacenes')->with('success', 'Almacén actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        $almacen->delete();

        return redirect()->route('admin.almacenes')->with('success', 'Almacén eliminado con éxito.');
    }
}
