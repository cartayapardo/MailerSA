<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $fillable = [
        'asunto',
        'destinatario',
        'cuerpo',
        'estado',
        'user_id'
    ];

    protected $casts = [
        'asunto' => 'string',
        'destinatario' => 'string',
        'cuerpo' => 'string',
        'estado' => 'string',
        'user_id' => 'integer'
    ];

    public static $rules = [
        'asunto' => 'required',
        'destinatario' => 'required',
        'cuerpo' => 'required',
        'estado' => 'required',
        'user_id' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
