<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    public function index()
    {
        $respuesta['data'] = $this->modelo->get();
        return ['logrado' => true, 'datos' => $respuesta['data'], 'sms' => 'Datos cargados correctamente'];
    }

    public function store(Request $parametros)
    {
        $nuevo = $this->modelo->create($parametros->all());
        if(!$nuevo){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la creación del elemento'];
        }
        return ['logrado' => true, 'datos' => $nuevo, 'sms' => 'Creación del elemento con éxito'];
    }

    public function update(Request $parametros, int $id)
    {
        $elemento = $this->find($id);
        if (!$elemento){
            return ['logrado' => false, 'datos' => null, 'sms' => 'No existe el elemento'];
        }
        $confirmado = $elemento->update($parametros->all());
        if(!$confirmado){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la actualización del elemento'];
        }
        // $editado = $this->find($id);
        return ['logrado' => true, 'datos' => $elemento, 'sms' => 'Actualización de los datos con éxito'];
    }

    public function delete(int $id)
    {
        $eliminado = $this->modelo->destroy($id);
        if(!$eliminado){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Ocurrió un error eliminando el elemento'];
        }
        return ['logrado' => true, 'datos' => null, 'sms' => 'Elemento eliminado con éxito'];
    }

    public function find($id, $with = [])
    {
        return $this->modelo->with($with)->find($id);
    }
}
