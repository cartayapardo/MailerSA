<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\CorreosUsuarios;
use App\Models\Correo;
use Illuminate\Http\Request;

class CorreoController extends BaseController
{
    public function __construct(Correo $Correo)
    {
        parent::__construct($Correo);
    }

    public function enviar()
    {
        $correos = Correo::where('estado', 'no enviado')->get();
        foreach ($correos as $correoUser) {
            Mail::to($correoUser->destinatario)->send(new CorreosUsuarios($correoUser));
        }
    }
}
