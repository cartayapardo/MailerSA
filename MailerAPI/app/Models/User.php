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
        'rol_id',
        'ciudad_id'
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
        'rol_id' => 'integer',
        'ciudad_id' => 'integer'
    ];

    public static $rules = [
        'email' => 'required',
        'contraseña' => 'required',
        'identificador' => 'required',
        'nombre' => 'required',
        'cedula' => 'required',
        'fechaNacimiento' => 'required',
        'codigoCiudad' => 'required',
        'rol_id' => 'required',
        'ciudad_id' => 'required'
    ];

    protected $with = ['rol', 'ciudad'];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }
}
