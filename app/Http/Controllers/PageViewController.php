<?php

namespace App\Http\Controllers;

use App\Models\PageView;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageViewController extends Controller
{
    use UserPermissions;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = $this->getUserPermissions();
        $pageviews = PageView::all();

        return Inertia::render('GestionarReportesEstadisticas/Views/index', [
            'views' => $pageviews,
            'canViewModuloUsuarios' => $permissions['canViewModuloUsuarios'],
            'canViewModuloInventario' => $permissions['canViewModuloInventario'],
            'canViewModuloVentas' => $permissions['canViewModuloVentas'],
            'canViewModuloReportes' => $permissions['canViewModuloReportes'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(PageView $pageView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageView $pageView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageView $pageView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageView $pageView)
    {
        //
    }
}
