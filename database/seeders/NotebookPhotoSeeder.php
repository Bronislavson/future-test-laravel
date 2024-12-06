<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\NotebookPhoto;
use App\Models\Notebook;

class NotebookPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем все записи из таблицы notebooks
        $notebooks = Notebook::all();

        foreach ($notebooks as $notebook) {
            // Генерируем случайное количество фотографий для каждой записи (например, от 1 до 3)
            $photoCount = rand(1, 3);

            for ($i = 0; $i < $photoCount; $i++) {
                // Генерация случайного пути к фотографии
                $photoName = Str::random(13) . '.jpg';
                $photoPath = env('APP_URL') . '/notebook_photos/' . $photoName;

                // Создание записи в таблице notebook_photos
                NotebookPhoto::create([
                    'notebook_id' => $notebook->id,
                    'photo_path' => $photoPath,
                ]);
            }
        }
    }
}
