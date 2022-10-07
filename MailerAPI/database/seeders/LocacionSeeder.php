<?php

namespace Database\Seeders;

use App\Models\Pais;
use App\Models\Estado;
use App\Models\Ciudad;
use Illuminate\Database\Seeder;

class LocacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creación de listado de paises de muestra
        $alemania = Pais::create([
            'nombre' => 'Alemania',
        ]);

        $argentina = Pais::create([
            'nombre' => 'Argentina',
        ]);

        $mexico = Pais::create([
            'nombre' => 'Mexico',
        ]);

        //Creación de listado de estados de muestra de Alemania
        $berlin = Estado::create([
            'nombre' => 'Berlin',
            'pais_id' => $alemania->id
        ]);

        $hamburgo = Estado::create([
            'nombre' => 'Hamburgo',
            'pais_id' => $alemania->id
        ]);

        $hesse = Estado::create([
            'nombre' => 'Hesse',
            'pais_id' => $alemania->id
        ]);

        //Creación de listado de estados de muestra de Argentina
        $buenosAires = Estado::create([
            'nombre' => 'Buenos Aires',
            'pais_id' => $argentina->id
        ]);

        $mendoza = Estado::create([
            'nombre' => 'Mendoza',
            'pais_id' => $argentina->id
        ]);

        $laPampa = Estado::create([
            'nombre' => 'La Pampa',
            'pais_id' => $argentina->id
        ]);

        //Creación de listado de estados de muestra de México
        $ciudadMexico = Estado::create([
            'nombre' => 'Ciudad de México',
            'pais_id' => $mexico->id
        ]);

        $veracruz = Estado::create([
            'nombre' => 'Veracruz',
            'pais_id' => $mexico->id
        ]);

        $jalisco = Estado::create([
            'nombre' => 'Jalisco',
            'pais_id' => $mexico->id
        ]);

        //Creación de listado de ciudades de muestra de Berlin
        Ciudad::create([
            'nombre' => 'Ciudad de Berlin',
            'estado_id' => $berlin->id
        ]);

        //Creación de listado de ciudades de muestra de Hamburgo
        Ciudad::create([
            'nombre' => 'Ciudad de Hamburgo',
            'estado_id' => $hamburgo->id
        ]);

        //Creación de listado de ciudades de muestra de Hesse
        Ciudad::create([
            'nombre' => 'Maintal',
            'estado_id' => $hesse->id
        ]);

        Ciudad::create([
            'nombre' => 'Hanau',
            'estado_id' => $hesse->id
        ]);

        Ciudad::create([
            'nombre' => 'Rodgau',
            'estado_id' => $hesse->id
        ]);

        //Creación de listado de ciudades de muestra de Buenos Aires
        Ciudad::create([
            'nombre' => 'Alberti',
            'estado_id' => $buenosAires->id
        ]);

        Ciudad::create([
            'nombre' => 'Arrecifes',
            'estado_id' => $buenosAires->id
        ]);

        //Creación de listado de ciudades de muestra de Mendoza
        Ciudad::create([
            'nombre' => 'Las Heras',
            'estado_id' => $mendoza->id
        ]);

        Ciudad::create([
            'nombre' => 'Godoy Cruz',
            'estado_id' => $mendoza->id
        ]);

        //Creación de listado de ciudades de muestra de La Pampa
        Ciudad::create([
            'nombre' => 'Santa Rosa',
            'estado_id' => $laPampa->id
        ]);

        Ciudad::create([
            'nombre' => 'General Pico',
            'estado_id' => $laPampa->id
        ]);

        Ciudad::create([
            'nombre' => 'Toay',
            'estado_id' => $laPampa->id
        ]);

        //Creación de listado de ciudades de muestra de Ciudad de México
        Ciudad::create([
            'nombre' => 'Miguel Hidalgo',
            'estado_id' => $ciudadMexico->id
        ]);

        Ciudad::create([
            'nombre' => 'Cuauhtémoc',
            'estado_id' => $ciudadMexico->id
        ]);

        //Creación de listado de ciudades de muestra de Veracruz
        Ciudad::create([
            'nombre' => 'Ciudad de Veracruz',
            'estado_id' => $veracruz->id
        ]);

        //Creación de listado de ciudades de muestra de Jalisco
        Ciudad::create([
            'nombre' => 'Guadalajara',
            'estado_id' => $jalisco->id
        ]);

        Ciudad::create([
            'nombre' => 'Puerto Vallarta',
            'estado_id' => $jalisco->id
        ]);

        Ciudad::create([
            'nombre' => 'El Salto',
            'estado_id' => $jalisco->id
        ]);
    }
}
