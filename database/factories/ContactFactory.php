<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $strengths = ['PHP', 'Laravel', 'Angular', 'React', 'Python', 'Vue.js', 'TailwindCSS', 'Wordpress'];
        shuffle($strengths);

        $softSkills = ['Diplomacy', 'Team player', 'Leadership', 'Sales experience', 'Presentation abilities', 'Public speaking', 'Conflict management'];
        shuffle($softSkills);

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->tollFreePhoneNumber(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'region' => $this->faker->state(),
            'country' => 'US',
            'postal_code' => $this->faker->postcode(),

            'description' => $this->faker->text,
            'strengths' => json_encode(array_slice($strengths, 0, 4)),
            'soft_skills' => json_encode(array_slice($softSkills, 0, 4)),
        ];
    }
}
