<?php

namespace App\Http\Controllers;

use App\Models\Traza;
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

    public function paginado(request $parametros)
    {
        $payload = $parametros->all();
        $respuesta = $this->model->get();
        return  $respuesta->paginate($payload['perPage'], ['*'], 'page', $payload['page']);
    }

    public function getBy(Request $parametros)
    {
        return $this->model->where($parametros['field'], $parametros['value'])->get();
    }

    public function store(Request $parametros)
    {
        $nuevo = $this->modelo->create($parametros->all());
        if(!$nuevo){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la creación del elemento'];
        }
        $usuario = request()->user();
        $this->crearTraza('Crear', $usuario, null, $nuevo);
        return ['logrado' => true, 'datos' => $nuevo, 'sms' => 'Creación del elemento con éxito'];
    }

    public function update(Request $parametros, int $id)
    {
        $anterior = $this->find($id);
        if (!$anterior){
            return ['logrado' => false, 'datos' => null, 'sms' => 'No existe el elemento'];
        }
        $nuevo = $anterior->update($parametros->all());
        if(!$nuevo){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Existe un error en la actualización del elemento'];
        }
        $usuario = request()->user();
        $this->crearTraza('Actualizar', $usuario, $anterior, $nuevo);
        return ['logrado' => true, 'datos' => $anterior, 'sms' => 'Actualización de los datos con éxito'];
    }

    public function delete(int $id)
    {
        $anterior = $this->modelo->destroy($id);
        if(!$anterior){
            return ['logrado' => false, 'datos' => null, 'sms' => 'Ocurrió un error eliminando el elemento'];
        }
        $usuario = request()->user();
        $this->crearTraza('Eliminar', $usuario, $anterior, null);
        return ['logrado' => true, 'datos' => null, 'sms' => 'Elemento eliminado con éxito'];
    }

    public function crearTraza($accion, $usuario, $anterior = null, $nuevo = null)
    {
        $traza['accion'] = $accion;
        $traza['usuario'] = $usuario->email;
        $traza['user_id'] = $usuario->id;
        $traza['anterior'] = $anterior;
        $traza['nuevo'] = $nuevo;
        $traza['modelo'] = class_basename(get_class($this->model));
        Traza::create($traza);
    }

    public function find($id, $with = [])
    {
        return $this->modelo->with($with)->find($id);
    }
}
