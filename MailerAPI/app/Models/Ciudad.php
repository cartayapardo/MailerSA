<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $fillable = [
        'nombre',
        'estado_id'
    ];

    protected $casts = [
        'nombre' => 'string',
        'estado_id' => 'integer'
    ];

    public static $rules = [
        'nombre' => 'required',
        'estado_id' => 'required'
    ];

    protected $with = ['estado'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'ciudad_id');
    }
}
