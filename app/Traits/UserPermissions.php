<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

trait UserPermissions
{
    /**
     * Obtener los permisos de un usuario.
     *
     * @return array
     */
    public function getUserPermissions()
    {
        $canViewModuloUsuarios = false;
        $canViewModuloInventario = false;
        $canViewModuloVentas = false;
        $canViewModuloReportes = false;

        if (Auth::check()) {
            $email = Auth::user()->email;
                $user = User::where('email', $email)->first();
            $canViewModuloUsuarios = $user->hasPermissionTo('ver-modulo-usuarios');
            $canViewModuloInventario = $user->hasPermissionTo('ver-modulo-inventario');
            $canViewModuloVentas = $user->hasPermissionTo('ver-modulo-ventas');
            $canViewModuloReportes = $user->hasPermissionTo('ver-modulo-reportes');
        }

        return [
            'canViewModuloUsuarios' => $canViewModuloUsuarios,
            'canViewModuloInventario' => $canViewModuloInventario,
            'canViewModuloVentas' => $canViewModuloVentas,
            'canViewModuloReportes' => $canViewModuloReportes,
        ];
    }
}
