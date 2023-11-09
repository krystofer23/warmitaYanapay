<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Llaves;
use App\Models\User;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioVictima;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
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
        
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ]);
    }
}
