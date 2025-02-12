<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth')->get('/api/user', [UserController::class, 'getUser']);
