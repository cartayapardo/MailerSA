<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends BaseController
{
    public function __construct(Estado $estado)
    {
        parent::__construct($estado);
    }
}
