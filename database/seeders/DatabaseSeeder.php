<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Llaves;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioVictima;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Llaves::create([
            'llave_acceso' => Hash::make('1C2D'),
        ]);

        UsuarioVictima::create([
            'dni' => '00001111',
            'nombre' => 'Mariana',
            'apellido' => 'Juana',
            'celular' => '987158476',
            'direccion' => 'Cipreses 4153 - Miraflores',
            'correo' => 'Mariana@gmail.com',
            'clave' => Hash::make('1234')
        ]);
    }
}
