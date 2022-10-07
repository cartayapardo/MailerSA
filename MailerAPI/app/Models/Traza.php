<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traza extends Model
{
    protected $fillable = [
        'accion',
        'usuario',
        'modelo',
        'nuevo',
        'anterior',
        'user_id'
    ];

    protected $casts = [
        'accion' => 'string',
        'usuario' => 'string',
        'modelo' => 'string',
        'anterior' => 'json',
        'nuevo' => 'json',
        'user_id' => 'integer'
    ];

    public static $rules = [
        'accion' => 'required',
        'usuario' => 'required',
        'modelo' => 'required',
        'user_id' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
