<?php

namespace Database\Factories;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganisationFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organisation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->tollFreeNumber,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->community,
            'state' => $this->faker->state,
            'country' => 'ES',
            'postal_code' => $this->faker->postcode,
        ];
    }
}
