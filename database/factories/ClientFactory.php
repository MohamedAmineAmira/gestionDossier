<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->firstName(),
            'prenom' => $this ->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' =>$this->faker->phoneNumber()
        ];
    }
}
