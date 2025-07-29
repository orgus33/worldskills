<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            ]);
        }


        for ($i = 1; $i <= 10; $i++) {
            DB::table('events')->insert([
                'name' => "Event {$i}",
                'description' => "Description for Event {$i}",
                'venu_name' => "Venue {$i}",
                'venu_address' => "Address {$i}",
                'city' => "City {$i}",
                'event_date' => now()->addDays($i),
                'doors_open' => now()->addDays($i)->subHours(2),
                'sale_starts_at' => now()->addDays($i)->subDays(10),
                'sale_ends_at' => now()->addDays($i)->subDays(),
                'min_age' => 18,
                'max_capacity' => 100 + ($i * 10),
                'tickets_sold' => 0,
                'status' => 'active',
                'image_url' => "https://example.com/image{$i}.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
