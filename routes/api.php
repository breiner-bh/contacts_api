<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Controller\ContactsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('contacts',ContactsController::class)->middleware('auth:sanctum');
Route::post('/contacts', [ContactsController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);
/*Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::get('/detalle_de_empleado/{empleado}',[EmpleadoController::class,'detalle_de_empleado'])->middleware('auth:sanctum');*/