<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use UserPermissions;
    public function index()
    {

        // Obtener todos los permisos
        $permissions = Permission::all();

        // Obtener el usuario autenticado y cargar los roles
       // dd(Auth::user()->roles);
        $roles = Auth::user()->roles;
        // Cargar los roles del usuario

        // Retornar la vista con Inertia
        return Inertia::render('GestionarUsuarios/Permisos/index', [
            'permissions' => $permissions, // Lista de permisos
            'roles' => $roles,               // Usuario con roles cargados

        ]);
    }


    public function create()
    {

        return Inertia::render('GestionarUsuarios/Permisos/create', [

        ]);
    }

    public function store(StorePermissionRequest $request)
    {
        // Ahora puedes usar el método validated()
        $validatedData = $request->validated();

        // Crear el permiso usando los datos validados
        Permission::create($validatedData);

        // Redirigir a la página de permisos
        return redirect()->route('admin.permisos');
    }

    public function edit(Permission $permission)
    {

        //dd($permission);
        // Lógica para mostrar el permiso específico que se va a editar
        return Inertia::render('GestionarUsuarios/Permisos/edit', [
            'permission' => $permission,

        ]);
    }

    public function destroy(Permission $permission)
    {
        // Eliminar usuario
        $permission->delete();

        // Redirigir después de eliminar
        return redirect()->route('admin.permisos');
    }

    public function update(StorePermissionRequest $request, Permission $permission)
    {
        $validatedData = $request->validated();
        $permission->update($validatedData);

        return redirect()->route('admin.permisos')->with('success', ' actualizado con éxito.');
    }
}
