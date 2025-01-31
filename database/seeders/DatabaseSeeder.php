<?php

namespace Database\Seeders;

use App\Models\Listings;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user=User::factory()->create([
            "name"=> "john",
            "email"=> "john@gmail.com"
        ]);

        Listings::factory(5)->create([
            "user_id"=> $user->id
        ]);

        // Listings::create([
        //    'title'=>'laravel intern',
        //    'tags'=> 'laravel,description',
        //    'company'=> 'acme corp',
        //    'email'=> 'email@email.com',
        //    'website'=> 'https://www.acme.com',
        //    'location'=> 'boston',
        //    'description'=>'laravel intern',
        // ]);

        // Listings::create([
        //     'title'=>'backend intern',
        //     'tags'=> 'backend,description',
        //     'company'=> 'acme corp',
        //     'email'=> 'email@email.com',
        //     'website'=> 'https://www.acme.com',
        //     'location'=> 'New york',
        //     'description'=>'laravel intern',
        //  ]);
    }
}
