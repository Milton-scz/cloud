<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Obtener el usuario autenticado
        $user = null;
        if (Auth::check()) {
            $email = Auth::user()->email;
            $user = User::where('email', $email)->first();
        }

        // Verificar si el usuario tiene el rol 'gerente'
        if ($user->hasPermissionTo('ver-dashboard')) {
           // dd($user->permissions  );
           return redirect()->intended(route('dashboard', absolute: false));
        }else{
            // dd($user);
            return redirect('/');
        }

        // Si no tiene el rol 'gerente', redirigir a la página principal u otra ruta

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
