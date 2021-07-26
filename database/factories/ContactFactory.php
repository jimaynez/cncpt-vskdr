<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

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
            'phone' => $this->faker->mobileNumber,
        ];
    }
}
