<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Producto;
use Illuminate\Http\Request;

use App\Models\Rating;
use App\Models\User;
use App\Traits\UserPermissions;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function PHPUnit\Framework\isEmpty;

class RatingController extends Controller
{

    public function index()
    {

        $ratings = Rating::with(['user', 'producto'])->get();
        return Inertia::render('GestionarFeedBack/Ratings/index', [
            'ratings' => $ratings,

        ]);
    }


    public function create()
    {

        $users = User::all();
        $productos = Producto::all();

        return Inertia::render('GestionarFeedBack/Ratings/create', [
            'users' => $users,
            'productos' => $productos,

        ]);
    }


    public function store(Request $request)
    {
       // dd($request);
        //$user = Auth::user()->id;
        //dd($user);
        $request->validate([
            'puntuacion' => 'required|integer|between:1,5',
        ]);

        // Verificar si el usuario ya ha calificado este producto
        $existingRating = Rating::where('producto_id', $request->producto_id)
                                ->where('user_id', $request->user_id)
                                ->first();

        if ($existingRating) {

            // Actualiza la calificación existente
            $existingRating->update([
                'puntuacion' => $request->puntuacion,
            ]);
        } else {
            // Crea una nueva calificación
      $rating=      Rating::create([
                'producto_id' => $request->producto_id,
                'user_id' => Auth::user()->id,
                'puntuacion' => $request->puntuacion,
            ]);

        }

        return redirect()->route('admin.ratings');
    }

    public function storerating(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'cedula' => 'required',
            'celular' => 'required',
            'puntuacion' => 'required|integer|between:1,5',
            'producto_id' => 'required|exists:productos,id',
            'comentario' => 'nullable|string',
        ]);


        $existingUser = User::where('email', $request->email)->first();


        if (!$existingUser) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cedula' => $request->cedula,
                'celular' => $request->celular,
                'password' => bcrypt('defaultpassword')
            ]);
        } else {
            $user = $existingUser;
        }

        $existingRating = Rating::where('producto_id', $request->producto_id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($existingRating) {
            $existingRating->update([
                'puntuacion' => $request->puntuacion,
                'comentario' => $request->comentario ?? '',
            ]);
        } else {
            Rating::create([
                'producto_id' => $request->producto_id,
                'user_id' => $user->id,
                'puntuacion' => $request->puntuacion,
                'comentario' => $request->comentario,
                'comentario' => $request->comentario ?? '',
            ]);
        }
        return redirect()->route('landing.productos');
    }
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('admin.ratings');
    }
}

