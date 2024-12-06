<?php

namespace Database\Factories;

use App\Models\NotebookPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotebookPhoto>
 */
class NotebookPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = NotebookPhoto::class;

    public function definition()
    {
        return [
            'notebook_id' => $this->faker->numberBetween(1, 10),
            'photo_path' => $this->faker->imageUrl(),
        ];
    }
}
