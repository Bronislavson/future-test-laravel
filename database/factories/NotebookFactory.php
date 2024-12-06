<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notebook;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notebook>
 */
class NotebookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    protected $model = Notebook::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'company' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'date_of_birth' => $this->faker->date(),
        ];
    }
}
