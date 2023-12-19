<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //      'name' => 'Test User',
        //     'email' => 'test@example.com',
        //  ]);

         \App\Models\User::factory()->create([
            'nom' => 'Ba',
            'prenom' => 'Mountaga',
            'adresse' => 'Patte d\'oie',
            'telephone' => '771663714',
            'email' => 'mountaga889@gmail.com',
            'password' => 'mountaga123',
            'role' => 'admin',
        ]);
    }
}
