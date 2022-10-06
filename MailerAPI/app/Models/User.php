<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'contraseña',
        'identificador',
        'nombre',
        'celular',
        'cedula',
        'fechaNacimiento',
        'codigoCiudad',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    protected $casts = [
        'email' => 'string',
        'contraseña' => 'string',
        'identificador' => 'integer',
        'nombre' => 'string',
        'celular' => 'string',
        'cedula' => 'string',
        'fechaNacimiento' => 'string',
        'codigoCiudad' => 'integer',
    ];

    public static $rules = [
        'email' => 'required',
        'contraseña' => 'required',
        'identificador' => 'required',
        'nombre' => 'required',
        'cedula' => 'required',
        'fechaNacimiento' => 'required',
        'codigoCiudad' => 'required',
    ];
}
