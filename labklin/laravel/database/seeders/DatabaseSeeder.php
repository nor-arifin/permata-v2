<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        //Manual Add User Seeder
        \App\Models\User::factory()->create([
            'name' => 'Nor Arifin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '085349393900',
        ]);
        //Manual Add Profile Clinic Seeder
        \App\Models\ProfileClinic::factory()->create([
            'logo' => 'logo.png',
            'name' => 'Clinic Lite',
            'email' => 'cliniclite.id@mail.com',
            'address' => 'Jl. Jalan No. 1',
            'phone' => '085349393900',
            'description' => 'Clinic Lite',
            'website' => 'www.cliniclite.id',
            'pic' => 'dr. Nor Arifin, Sp.PK',
            'acreditation' => 'Paripurna',
            'status' => 'Active',
            'faskes_id' => 'F2311962',
        ]);

        //calling other seeders
        $this->call([
            DoctorSeeder::class,
            DoctorScheduleSeeder::class,
            PatientSeeder::class,
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);
    }
}
