<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_name' => $this->faker->name(),
            'doctor_gender' => $this->faker->randomElement(['male', 'female']),
            'doctor_birthdate' => $this->faker->date('Y-m-d'),
            'doctor_nik' => $this->faker->unique()->numberBetween(1234567890123456, 9234567890123456),
            'doctor_email' => $this->faker->unique()->safeEmail(),
            'doctor_phone' => $this->faker->phoneNumber(),
            'doctor_sip' => $this->faker->word(),
            'doctor_speciality' => $this->faker->word(),
            'doctor_photo' => $this->faker->imageUrl(),
            'doctor_id' => $this->faker->unique()->numberBetween(100000000, 9999900000),
        ];
    }
}
