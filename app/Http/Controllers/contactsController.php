<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;


class ContactsController extends Controller
{
    public function store( Request $request){
        $datos = $request->validate([
            'name' => ['required','string','max:255'],
            'user_id' => ['required','integer','exists:users,id'],
            'phone_number' =>['required','numeric','unique:contacts,phone_number']
            ],
            [ 'phone_number.unique' => 'el numero de teledfono que desea guardar ya se encuentra registrado'
        ]);
        $contactos = Contacts::create([
            'name'=>$datos['name'],
            'user_id'=>$datos['user_id'],
            'phone_number'=>$datos['phone_number']
        ]);
        return response()->json([
            'success'=>true,
            'message' =>'contacto creado con exito',
            'data' => $contactos
        ], 201);
    }
    public function index(){
        $contactos = Contacts::paginate(5);
        if(!$contactos){
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
    public function show( int $id)
    {
        $contactos = Contacts::find($id);
        if(!$contactos)
            {
                return response()->json([
                    'success' => true,
                    'message' =>'Contacto no existe o no registrado .'
                ],404);
            }else {
                return response()->json([
                    'success' => true,
                    'message' => 'Contacto encontrado.'
                ], 200);
            }
    }
    public function update(Request $request, Contacts $contact)
    {
        $datos = $request->validate([
            'name'=>['required','string','max:255'],
            'user_id'=>['required','integer','exists:users,id'],
            'phone_number'=>['required','numeric']
        ]);
        $contact->update([
            'name'=>$datos['name'],
            'user_id'=>$datos['user_id'],
            'phone_number'=>$datos['phone_number']
        ]);
        return response()->json([
            'success' => true,
            'message' => 'contacto actualizado con exito',
            'data' => $contact->refresh(),
        ],200);
    }
    public function destroy( int $id)
    {
        $contacto = Contacts::find($id);
        if(is_null($contacto))
            {
                return response()->json([
                    'success' => true,
                    'message' => 'Contacto no existe.'
                ],404);
            } else {
                $contacto_eliminado = $contacto->delete();
                return response()->json([
                    'success' => true,
                    'menssage' => 'Contacto eliminado exitosamente',
                    'data' => $contacto_eliminado
                ], 200);
            }
    }

}
