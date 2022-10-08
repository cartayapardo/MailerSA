<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'nombre',
        'pais_id'
    ];

    protected $casts = [
        'nombre' => 'string',
        'pais_id' => 'integer'
    ];

    public static $rules = [
        'nombre' => 'required',
        'pais_id' => 'required'
    ];

    protected $with = ['pais'];

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'estado_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
}
