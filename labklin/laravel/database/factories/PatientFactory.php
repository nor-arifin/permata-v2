<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_mr' => $this->faker->numberBetween(100000, 999999),
            'patient_ihs' => $this->faker->numberBetween(100000, 999999),
            'patient_identifier' => 'nik',
            'patient_nik' => $this->faker->numberBetween(1234567890123456, 2234567890123456),
            'patient_kk' => $this->faker->numberBetween(1234567890123456, 2234567890123456),
            'patient_name' => $this->faker->name(),
            'patient_gender' => $this->faker->randomElement(['male', 'female']),
            'patient_birthplace' => $this->faker->city(),
            'patient_birthdate' => $this->faker->date(),
            'patient_telecom' => $this->faker->phoneNumber(),
            'patient_email' => $this->faker->email(),
            'patient_address_use' => 'home',
            'patient_address_line' => $this->faker->address(),
            'patient_address_city' => $this->faker->city(),
            'patient_address_country' => 'ID',
            'patient_address_postalcode' => $this->faker->postcode(),
            'patient_address_extension' => $this->faker->numberBetween(62010101, 69010101),
            'patient_code_province' => $this->faker->numberBetween(62, 69),
            'patient_code_city' => $this->faker->numberBetween(11, 99),
            'patient_code_district' => $this->faker->numberBetween(11, 99),
            'patient_code_village' => $this->faker->numberBetween(11, 99),
            'patient_code_rt' => $this->faker->numberBetween(11, 20),
            'patient_code_rw' => $this->faker->numberBetween(11, 20),
            'patient_marital_status' => $this->faker->randomElement(['S', 'M', 'W', 'D']),
            'patient_relationship_name' => $this->faker->name(),
            'patient_relationship_phone' => $this->faker->phoneNumber(),
            'patient_citizenship_status' => $this->faker->randomElement(['WNI', 'WNA', 'WNI-ASING']),
            'patient_status' => 'registered',
            'patient_bpjs' => $this->faker->numberBetween(1234567890, 2234567890),
            'patient_religion' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya']),
            'patient_title' => $this->faker->randomElement(['Mr', 'Mrs', 'Miss','Baby', 'RIP']),
            'patient_deceased' => 'false',
            'patient_profession' => $this->faker->jobTitle(),
            'patient_bloodtype' => $this->faker->randomElement(['A', 'B', 'AB', 'O','-']),
        ];
    }
}
