<?php

namespace App\Http\Controllers;

use App\Models\Traza;
use Illuminate\Http\Request;

class TrazaController extends Controller
{
    public function __construct(Traza $Traza)
    {
        parent::__construct($Traza);
    }
}
