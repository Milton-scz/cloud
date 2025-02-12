<?php

namespace App\Http\Controllers;

use App\Models\AjusteInventario;
use App\Models\Almacen;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AjusteInventarioController extends Controller
{

    public function index()
    {
        $productos = Producto::all();
        $almacenes = Almacen::all();
        $ajustes = AjusteInventario::with(['producto','almacen'])->get();
        return Inertia::render('GestionarInventario/AjustesInventarios/ajuste_index', [
            'almacenes' => $almacenes,
            'productos' => $productos,
            'ajustes' => $ajustes,
        ]);

    }



    public function agregar(Request $request)
    {

        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'almacen_id' => 'required|exists:almacens,id',
            'tipo' => 'required|integer|in:1,2',
            'descripcion' => 'required|string',
        ]);

        $almacen = Almacen::findOrFail($validated['almacen_id']);
        $producto = Producto::findOrFail($validated['producto_id']);

        // Obtener el stock actual del producto en el almacén
        $stockActual = $almacen->productos()->where('producto_id', $producto->id)->first()->pivot->stock ?? 0;
        $capacidadAlmacen = $almacen->capacidad;
        $stockTotalActual = $almacen->productos()->sum('producto_almacens.stock');

        if ($validated['tipo'] == 2) {
            // Si es tipo 2 (restar), verificar si hay suficiente stock
            if ($stockActual < $validated['cantidad']) {
                return response()->json([
                    'message' => 'No hay suficiente stock para realizar el ajuste.'

                ]);
            }
            $stockNuevo = $stockActual - $validated['cantidad'];
            DB::table('producto_almacens')->updateOrInsert(
                ['producto_id' => $producto->id, 'almacen_id' => $almacen->id],
                ['stock' => $stockNuevo]
            );
        } else {
            // Si es tipo 1 (sumar), verificar que no exceda la capacidad del almacén
            if (($stockTotalActual + $validated['cantidad']) > $capacidadAlmacen) {

                return response()->json([
                    'message' => 'No se puede agregar el producto. Se excede la capacidad del almacén.'

                ]);
            }
            $stockNuevo = $stockActual + $validated['cantidad'];
            DB::table('producto_almacens')->updateOrInsert(
                ['producto_id' => $producto->id, 'almacen_id' => $almacen->id],
                ['stock' => $stockNuevo]
            );
        }

        // Registrar el ajuste de inventario
        AjusteInventario::create([
            'producto_id' => $producto->id,
            'almacen_id' => $almacen->id,
            'cantidad' => $validated['cantidad'],
            'tipo' => $validated['tipo'],
            'descripcion' => $validated['descripcion'],
        ]);

        return response()->json([
            'message' => 'Ajuste de inventario realizado correctamente.'

        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AjusteInventario $ajusteinventario)
    {

        $ajusteinventario->delete();
        return redirect()->route('admin.ajustesinventarios');
    }
}
