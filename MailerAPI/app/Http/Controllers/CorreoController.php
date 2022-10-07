<?php

namespace App\Http\Controllers;

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

    }
}
