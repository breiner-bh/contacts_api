<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;

use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' =>['required','email'],
            'password' =>['required']
        ]);
         if (Auth::attempt($credenciales)) {
            /**@var \App\Models\User $user */
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'message'=>'usuario  a creado sesion con exito',
                'data' => $user
                ], 201);
        }else {
            response()->json([
                'success' => true,
                'message' => 'Credenciales invalidas',
            ],401);
        }
    }
    public function register(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:user,email'],
            'password' => ['required','string','min:8']
            ],[
                'email.unique' => 'el correo del usuario que deseas iniciar ya se encuentra registrado en la base de datos'
        ]);
        if($validator->fails())
            {
                return response()->json([
                    'success' => true,
                    'message' => validator()->errors()->first()
                ], 422);
            }
        $datosvalidados = $validator->validated();
        $user = \App\Models\User::create([
            'name' => $validator['name'],
            'email' => $validator['email'],
            'password' => bcrypt($validator('password'))

        ]);
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'usuario registrado exitosamente',
            'data' => $user
        ],201); 
    }
    public function logout (Required $request)
    {
        $request->user()->currentAccessToken('token')->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cierre de sesion con exito'
        ], 200);
    }
}
