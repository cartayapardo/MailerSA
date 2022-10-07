<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Se crean los permisos de la aplicación
        $permiso = Permiso::create([
            'nombre' => 'Gestionar Usuario',
            'codigo' => 'P101',
        ]);

        // Se crean los roles de la aplicación
        $admin = Rol::create([
            'nombre' => 'administrador',
        ]);

        Rol::create([
            'nombre' => 'usuario',
        ]);

        // Se asignan los permisos a los roles
        $admin->permisos()->sync([$permiso->id]);

        // Se crean los usuarios iniciales de la aplicación
        User::create([
            'nombre' => 'admin',
            'email' => 'admin@gmail.com',
            'contraseña' => Hash::make('Administrador1'),
            'identificador' => 1000,
            'celular' => '56455434',
            'cedula' => 'uiytuiyyg',
            'fechaNacimiento' => Carbon::now(),
            'codigoCiudad' => 9867,
            'rol_id' => $admin->id,
        ]);
    }
}
