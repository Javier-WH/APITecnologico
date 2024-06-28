<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            try {
                User::create([
                    'id' => Str::uuid(),
                    'user' => 'defaultAdmin',
                    'password' => '123456789',
                    'level' => '1',
                ]);
                info('Se ha creado el administrador por defecto: defaultAdmin');

                User::create([
                    'id' => Str::uuid(),
                    'user' => 'defaultUser',
                    'password' => '123456789',
                    'level' => '2',
                ]);
                info('Se ha creado el usuario por defecto: admin');
            } catch (\Throwable $th) {
                info($th->getMessage());
            }
        }
    }
}
