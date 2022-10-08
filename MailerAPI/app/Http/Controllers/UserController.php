<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function autenticacion(Request $request)
    {
        $fields = $request->validate(
            [
                'credencial' => 'required|string',
                'contraseña' => 'required|string'
            ]
        );
        $usuario = User::where('email', $fields['credencial'])->first();
        if (!$usuario || !Hash::check($fields['contraseña'], $usuario->contraseña)){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Sus credenciales no son correctas'];
        }
        $token = $usuario->createToken('mytoken')->plainTextToken;
        $respuesta = [
            'usuario' => $usuario,
            'token' => $token
        ];
        return ['logrado' => true, 'datos' => $respuesta, 'sms' => 'Sus credenciales son correctas'];
    }

    public function cerrar(Request $request){
            $user = $request->user();
            $user->tokens()->where('id', explode('|', $request->bearerToken())[0])->delete();
            return ['logrado' => true, 'datos' => null, 'sms' => 'Salida de la aplicación con exito'];
    }

    public function guardar(Request $request){
        $parametros = $request->all();
        $parametros['contraseña'] = Hash::make($parametros['contraseña']);
        $nuevo = User::create($parametros);
        if(!$nuevo){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la creación del elemento'];
        }
        $usuario = request()->user();
        $this->crearTraza('Crear', $usuario, null, $nuevo);
        return ['logrado' => true, 'datos' => $nuevo, 'sms' => 'Creación del elemento con éxito'];
}
}
