<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Traits\UserPermissions;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VentaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(){

        $ventas = Venta::with('user')->get();
        return Inertia::render('GestionarVentas/Ventas/index', [
            'ventas' => $ventas,

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::all();
        return Inertia::render('GestionarVentas/Ventas/generarventa', [
            'users' => $users,

        ]);
    }



    public function catalogo()
    {

        $productos = Producto::all();
        return Inertia::render('GestionarVentas/Ventas/catalogo', [
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
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('admin.ventas');
    }
}
