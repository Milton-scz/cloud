<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProveedorController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $proveedores = Proveedor::paginate(10);

        return Inertia::render('GestionarInventario/Proveedores/index', [
            'proveedores' => $proveedores,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return Inertia::render('GestionarInventario/Proveedores/create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedorRequest  $request)
    {
        $validatedData = $request->validated();
        Proveedor::create($validatedData);
        return redirect()->route('admin.proveedores');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {

        return Inertia::render('GestionarInventario/Proveedores/edit', [
            'proveedor' => $proveedor,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $validatedData = $request->validate([
            'nit' => 'required',
            'razonsocial' => 'required|string|max:255',
            'celular' => 'required',
            'email' => 'required',

        ]);
        $proveedor->update($validatedData);

        return redirect()->route('admin.proveedores')->with('success', ' actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
