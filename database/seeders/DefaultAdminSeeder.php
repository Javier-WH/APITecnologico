<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Tests\TestCase;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    //ESTOS SEEDERS SON NECESARIOS PARA LAS PRUEBAS UNITARIAS, SI SE ELIMINAN NO SE EJECUTARAN, POR LO TANTO LOS DATOS DE LA BASE DE DATOS SON DE PRUEBA.
    public function run(): void
    {

        try {
            User::create([
                'id' => Str::uuid(),
                'user' => TestCase::defaultAdmin,
                'password' => TestCase::defaultPassword,
                'level' => '1',
            ]);
            info('Se ha creado el administrador por defecto: defaultAdmin');

            User::create([
                'id' => Str::uuid(),
                'user' => TestCase::defaultUser,
                'password' => TestCase::defaultPassword,
                'level' => '2',
            ]);

            User::create([
                'id' => Str::uuid(),
                'user' => TestCase::defaultGuest,
                'password' => TestCase::defaultPassword,
                'level' => '3',
            ]);
        } catch (\Throwable $th) {
            info($th->getMessage());
        }
    }
}
