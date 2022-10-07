<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
    ];

    protected $casts = [
        'nombre' => 'string',
        'codigo' => 'string',
    ];

    public static $rules = [
        'nombre' => 'required',
        'codigo' => 'required',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class,'permiso_roles', 'rol_id','permiso_id' );
    }
}
