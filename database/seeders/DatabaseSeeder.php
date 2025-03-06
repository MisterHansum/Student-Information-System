<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Insert a default user
        User::create([
            'name' => 'Johnny Bravo',
            'email' => 'bravo@gmail.com',
            'password' => Hash::make('12345678'), // Hash the password
            'role' => 'student',
        ]);



        // Call additional seeders
        $this->call([
            SubjectSeeder::class,  // Ensure this class exists in your seeders
        ]);
    }
}
