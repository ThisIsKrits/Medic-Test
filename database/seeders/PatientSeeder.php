<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        foreach (range(1, 50) as $i) {
            Patient::create([
                'name'       => $faker->name,
                'birthdate'  => $faker->date('Y-m-d', '-10 years'),
                'gender'     => $faker->randomElement(['M', 'F']),
                'phone'      => $faker->phoneNumber,
                'address'    => $faker->address,
                'status'     => $faker->randomElement(['Y', 'N']),
            ]);
        }
    }
}
