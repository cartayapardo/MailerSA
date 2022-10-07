<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
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

    public function estados()
    {
        return $this->hasMany(Estado::class, 'pais_id');
    }
}
