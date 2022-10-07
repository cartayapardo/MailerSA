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
                'credential' => 'required|string',
                'password' => 'required|string'
            ]
        );
        $usuario = User::where('email', $fields['credential'])->first();
        if (!$usuario || !Hash::check($fields['password'], $usuario->password)){
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
}
