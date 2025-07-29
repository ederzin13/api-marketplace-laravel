<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        //isso daqui é só pra quando os dois usuários padrão aí de cima
        //já existirem. Se eles não existirem no momento de rodar o seeder, 
        //favor comentar as 4 linhas abaixo
        Cart::factory(2)->state(new Sequence(
            ["userId" => 1],
            ["userId" => 2]
        ))->create();

        Category::factory(10)->create();

        Address::factory(10)->create();

        Product::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
