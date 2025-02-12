<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleStoreRequest;
use App\Models\Role as ModelsRole;
use App\Traits\UserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::all();
        // Cargar todos los roles con sus permisos asociados
        $roles = Role::with('permissions')->get(); // Cargar roles con permisos asociados
   // dd($roles);
        // Retornar los datos a la vista usando Inertia
        return Inertia::render('GestionarUsuarios/Roles/index', [
            'roles' => $roles, // Pasar los roles con permisos a la vista
            'permissions' => $permissions,

        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('GestionarUsuarios/Roles/create', [


        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        //dd($request);
        $validatedData = $request->validated();
        Role::create($validatedData);
        return redirect()->route('admin.roles');
    }

    public function assignPermissions(Request $request, $roleId)
    {
        // Buscar el rol
        $role = Role::findOrFail($roleId);

        // Obtener los permisos actuales del rol antes de la sincronización
        $currentPermissions = $role->permissions()->pluck('permissions.id')->toArray();

        // Sincronizar los permisos para el rol, agregando los nuevos sin eliminar los anteriores
        $role->permissions()->syncWithoutDetaching($request->permissions);

        // Identificar los nuevos permisos asignados
        $newPermissions = array_diff($request->permissions, $currentPermissions);

        if (!empty($newPermissions)) {
            // Obtener los usuarios que tienen este rol
            $usersWithRole = $role->users; // Suponiendo que la relación User-Role está definida como 'users'

            foreach ($usersWithRole as $user) {
                dd($usersWithRole);
                // Insertar los nuevos permisos para cada usuario en la tabla intermedia `user_permission`
                $user->permissions()->syncWithoutDetaching($newPermissions);
            }
        }

        return response()->json([
            'role' => $role->load('permissions'), // Cargar los permisos después de la asignación
        ]);
    }
    public function removePermissions(Request $request, Role $role)
    {
        // Verifica que los permisos sean válidos
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Remover los permisos seleccionados
        $role->permissions()->detach($validated['permissions']);

        return response()->json([
            'role' => $role->load('permissions'),
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        //dd($permission);
        // Lógica para mostrar el permiso específico que se va a editar
        return Inertia::render('GestionarUsuarios/Roles/edit', [
            'role' => $role,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'guard_name' => 'required|string|max:255',

        ]);
        $role->update($validatedData);

        return redirect()->route('admin.roles')->with('success', ' actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsRole $role)
    {
       // dd($role);
        $role->delete();

        return redirect()->route('admin.roles');
    }
}
