<?php

namespace App\Http\Controllers;
use App\Models\concacts;
use Illuminate\Http\Request;

class contacts extends Controller
{
    public function store( Request $request){
        $datos = $request->validate([
            'name' => ['required','string','max:255'],
            'user_id' => ['required','interger','exists:user'],
            'phone_number' =>['required','numeric']
        ]);
        $contactos = concacts::create([
            'name'=>$datos['name'],
            'user_id'=>$datos['user_id'],
            'phone_number'=>$datos['phone_number']
        ]);
        return response()->json([
            'success'=>true,
            'message' =>'contacto creado con exito',
            'data' => $contactos
        ], 200);
    }
    public function index(){
        $contactos = contacts::paginate(5);
        if(!$contactos->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron contactos registrados'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'lista de contactos registrados',
                'date' => $contactos 
            ],200);
        }
    }
}
