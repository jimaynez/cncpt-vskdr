<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $fake_first_name = $this->faker->firstName;
        $fake_last_name = $this->faker->lastName;
        $fake_digit = $this->faker->numberBetween(0, 100);
        $fake_domain = $this->faker->freeEmailDomain;
        $fake_last_name_email = Str::replace(' ', '', $fake_last_name);
        
        $fake_email = $fake_last_name_email . $fake_first_name . $fake_digit . '@' . $fake_domain;

        return [
            'first_name' => $fake_first_name,
            'last_name' => $fake_last_name,
            'email' => $fake_email,
            'email_verified_at' => now(),
            'password' => 'secret',
            'remember_token' => Str::random(10),
            'owner' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified() {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
