<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notebook;
use Faker\Factory as Faker;

class NotebookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Notebook::create([
                'full_name' => $faker->name,
                'company' => $faker->company,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'date_of_birth' => $faker->date(),
            ]);
        }
    }
}
