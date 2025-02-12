<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Traits\UserPermissions; // Importar el trait
class UserController extends Controller
{

    /**
     * Get the permissions for the user.
     *
     * @return array
     */


    public function index()
    {


        // Obtener usuarios con roles
        $users = User::with('roles')->paginate(10);

        return Inertia::render('GestionarUsuarios/Usuarios/index', [
            'users' => $users,

        ]);
    }

    public function create()
    {

        $roles = Role::all();

        return Inertia::render('GestionarUsuarios/Usuarios/create', [
            'roles' => $roles,

        ]);
    }

    public function store(UserStoreRequest $request)
    {

        // Validar los datos del request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'celular' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        // Encriptar la contraseña
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        // Asignar el rol al usuario
        $user->assignRole($validated['role']);
     //   $user->roles()->attach($validated['role']);

        // Redirigir después de la creación del usuario
        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {

        $roles = Role::all();
        return Inertia::render('GestionarUsuarios/Usuarios/edit', [
            'user' => $user,
            'roles' => $roles,

        ]);
    }

    public function update(Request $request, User $user)
    {
        // Validar los datos del request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'celular' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
        ]);

        // Encriptar la contraseña si es proporcionada
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Eliminar campo de contraseña si no es actualizado
        }

        // Actualizar el usuario
        $user->update($validatedData);

        // Actualizar el rol del usuario
        $user->roles()->sync([$validatedData['role']]);

        // Redirigir con éxito
        return redirect()->route('admin.users')->with('success', 'Usuario y rol actualizados exitosamente.');
    }

    public function destroy(User $user)
    {
        // Eliminar usuario

        $user->delete();

        // Redirigir después de eliminar
        return redirect()->route('admin.users');
    }

    public function getUser(Request $request)
    {
        $user = $request->user();
dd($user);
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ]);
    }
}
