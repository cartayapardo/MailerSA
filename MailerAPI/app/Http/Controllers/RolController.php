<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends BaseController
{
    public function __construct(Rol $rol)
    {
        parent::__construct($rol);
    }
}
