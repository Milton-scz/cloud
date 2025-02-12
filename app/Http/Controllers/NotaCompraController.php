<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\DetalleCompra;
use App\Models\NotaCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotaCompraController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notascompras = NotaCompra::with(['proveedor', 'productos'])->paginate(20);
        return Inertia::render('GestionarInventario/NotasCompras/index', [
            'notascompras' => $notascompras,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return Inertia::render('GestionarInventario/NotasCompras/create', [
            'proveedores' => $proveedores,
            'productos' => $productos,

        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'fecha' => 'required|date',
            'glosa' => 'required|string|max:255',
            'productos' => 'required|array',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',

        ]);
       // dd($request);
        // Crear la nota de compra
        $notaCompra = NotaCompra::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha' => $request->fecha,
            'glosa' => $request->glosa,
        ]);

        // Crear el detalle de la compra
        foreach ($request->productos as $detalle) {
          //   dd( $notaCompra->id);
            DetalleCompra::create([
                'nota_compra_id' => $notaCompra->id,
                'producto_id' => $detalle['producto_id'],
                'cantidad' => $detalle['cantidad'],
                'precio' => $detalle['precio'],
            ]);
        }

        return redirect()->route('admin.notascompras')->with('success', 'Nota de compra creada correctamente.');
    }


    public function destroy(NotaCompra $notacompra)
    {
        // Eliminar la nota de compra
        $notacompra->delete();

        // Obtener las notas de compra paginadas
        $notascompras = NotaCompra::with('proveedor')->paginate(10);
//dd($notascompras);
        // Redirigir a la ruta y pasar las notas de compra con el mensaje de éxito
        return redirect()->route('admin.notascompras')
                         ->with('notascompras', $notascompras)
                         ->with('success', 'Nota de compra eliminada correctamente.');
    }

}
