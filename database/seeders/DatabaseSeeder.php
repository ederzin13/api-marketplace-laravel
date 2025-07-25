<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
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
        // User::factory(10)->create();
        User::factory()->create([
            "name" => "administrador SILVA",
            "email" => "adm@email.com",
            "password" => "administrador",
            "role" => "admin"
        ]);

        User::factory()->create([
            "name" => "normal comum",
            "email" => "padrao@email.com",
            "password" => "normalcomum",
            "role" => "client"
        ]);

        Category::factory(10)->create();

        Address::factory(10)->create();

        Product::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
