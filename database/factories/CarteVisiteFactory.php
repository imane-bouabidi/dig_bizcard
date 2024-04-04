<?php

namespace Database\Factories;

use App\Models\CarteVisite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarteVisite>
 */
class CarteVisiteFactory extends Factory
{
    protected $model = CarteVisite::class;

    public function definition()
    {
        return [
            'nom' => $this->faker->name,
            'tel' => $this->faker->phoneNumber,
            'entreprise' => $this->faker->company,
            'titre' => $this->faker->jobTitle,
            'coordonnees' => $this->faker->address,
            'description' => $this->faker->sentence,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
