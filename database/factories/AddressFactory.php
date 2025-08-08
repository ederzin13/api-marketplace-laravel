<?php
// APENAS PARA FIM DE TESTES POR ENQUANTO VAMOS VER
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "userId" => 1,
            "street" => fake()->streetName(),
            "number" => fake()->randomNumber(3),
            "zip" => fake()->randomNumber(5),
            "city" => fake()->city(),
            "state" => fake()->word(),
            "country" => fake()->country()
        ];
    }
}
