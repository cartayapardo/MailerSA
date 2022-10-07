<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [
        'nombre',
    ];

    protected $casts = [
        'nombre' => 'string',
    ];

    public static $rules = [
        'nombre' => 'required',
    ];

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class,'permiso_roles', 'permiso_id','rol_id' );
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
