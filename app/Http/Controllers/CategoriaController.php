<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria\CategoriaStoreRequest;
use App\Models\Categoria;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categorias = Categoria::all();

        return Inertia::render('GestionarInventario/Categorias/index', [
            'categorias' => $categorias,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('GestionarInventario/Categorias/create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaStoreRequest $request)
    {
        $validatedData = $request->validated();
        Categoria::create($validatedData);
        return redirect()->route('admin.categorias');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {

        //dd($permission);
        // Lógica para mostrar el permiso específico que se va a editar
        return Inertia::render('GestionarInventario/Categorias/edit', [
            'categoria' => $categoria,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',

        ]);
        $categoria->update($validatedData);

        return redirect()->route('admin.categorias')->with('success', ' actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('admin.categorias');
    }
}
