<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends BaseController
{
    public function __construct(Pais $pais)
    {
        parent::__construct($pais);
    }
}
