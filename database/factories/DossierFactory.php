<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DossierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date_depot_prevu' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'client_id'=>rand(1,10),
            'type_dossier_id'=>rand(1,10), 
        ];
    }
}
