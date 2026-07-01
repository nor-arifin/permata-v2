<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create doctor schedules
        \App\Models\DoctorSchedule::create([
            'doctor_id' => 1,
            'day' => 'Sunday',
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'status' => 'active',
            'note' => 'executive',
        ]);
        //auto generate doctor schedule
        \App\Models\Doctor::all()->each(function ($doctor) {
            \App\Models\DoctorSchedule::factory(3)->create([
                'doctor_id' => $doctor->id
            ]);
        });

    }
}
