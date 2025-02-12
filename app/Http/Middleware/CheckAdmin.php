<?php
namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next) // Recibe el parámetro $role
    {
        $user = Auth::user();
        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();
        // Verifica si el usuario tiene el rol adecuado
        if (!$user || !$user->hasRole('gerente')) {
            // Si no tiene el rol adecuado, redirige o lanza un error
            dd($user);
            return redirect()->route('/');
        }

        // Continúa con la solicitud si el rol es adecuado
        return $next($request);
    }
}
