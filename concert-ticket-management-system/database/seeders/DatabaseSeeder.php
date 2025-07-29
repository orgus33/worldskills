<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        foreach ([20, 30, 40] as $i => $age) {
            User::create([
                'firstname' => "Test{$i}",
                'lastname' => "User",
                'email' => "testuser{$i}@mail.com",
                'phone' => "+3361234567{$i}",
                'date_of_birth' => now()->subYears($age)->format('Y-m-d'),
                'password' => Hash::make('Password123'),
                'token' => $newToken = Str::random(60)
            ]);
        }
    }
}
