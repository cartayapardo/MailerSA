<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadController extends BaseController
{
    public function __construct(Ciudad $ciudad)
    {
        parent::__construct($ciudad);
    }
}
