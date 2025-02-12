<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\ProductoStoreRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Traits\UserPermissions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{

    public function index()
    {
        // Cargar productos con sus relaciones de categoria y almacenes
        $productos = Producto::with(['categoria', 'almacenes'])->get()->map(function ($producto) {
            // Sumar el stock de los almacenes relacionados
            $producto->stock_total = $producto->almacenes->sum('pivot.stock');
            return $producto;
        });

        return Inertia::render('GestionarInventario/Productos/index', [
            'productos' => $productos,
        ]);
    }



    public function create()
    {

        $categorias = Categoria::all();

        return Inertia::render('GestionarInventario/Productos/create', [
            'categorias' => $categorias,

        ]);
    }




    public function store(ProductoStoreRequest $request) {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Otros campos
        ]);

        if ($request->hasFile('imagen')) {
            // Procesar la imagen
            $image = $request->file('imagen');

            // Ruta accesible públicamente (en servidores compartidos suele ser 'public_html/imagenes/')
            $destinationPath = 'imagenes/';
            $filename = time() . '-' . $image->getClientOriginalName();

            // Mover la imagen al directorio
            $image->move(public_path($destinationPath), $filename);

            // Generar la URL completa basada en el dominio del servidor
            $urlCompleta = url($destinationPath . $filename);

            // Crear el producto con la URL completa de la imagen
            $producto = Producto::create([
                'nombre' => $request->nombre,
                'imagen' => $urlCompleta, // Guardar la URL completa
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'stock' => 0,
                'categoria_id' => $request->categoria_id,
            ]);
        }

        return redirect()->route('admin.productos');
    }


    public function show(Producto $producto)
    {
        //
    }


    public function edit(Producto $producto)
    {

        $categorias = Categoria::all();
        return Inertia::render('GestionarInventario/Productos/edit', [
            'producto' => $producto,
            'categorias' => $categorias,

        ]);
    }


    public function update(Request $request, Producto $producto)
    {
        $data = $request->except('imagen');
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $destinationPath = 'imagenes/';
            $filename = time() . '-' . $file->getClientOriginalName();

            // Mover la imagen al directorio
            $file->move(public_path($destinationPath), $filename);

            // Generar la URL completa basada en el dominio del servidor
            $urlCompleta = url($destinationPath . $filename);
            $data['imagen'] = $urlCompleta;

            if($producto->imagen){
            Storage::disk('public')->delete($producto->imagen);
            }
        }
        $producto->update($data);
        return redirect()->route('admin.productos');
    }


    public function destroy(Producto $producto)
    {
        if($producto->imagen){
            Storage::disk('public')->delete($producto->imagen);
            }
        $producto->delete();
        return redirect()->route('admin.productos');
    }
}
