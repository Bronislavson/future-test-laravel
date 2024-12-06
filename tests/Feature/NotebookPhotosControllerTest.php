<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\NotebookPhoto;
use App\Models\Notebook;

class NotebookPhotosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_notebook_photo()
    {
        // Создаем связанный notebook
        $notebook = Notebook::factory()->create();

        // Генерируем фейковое изображение
        $file = UploadedFile::fake()->image('test_photo.png');

        // Данные для запроса
        $data = [
            'notebook_id' => $notebook->id, // Можно заменить на реальный ID, если он существует
            'photo' => $file,
        ];

        // Отправляем POST-запрос к методу store
        $response = $this->postJson('/api/v1/notebook-photos', $data);

        // Проверяем, что ответ успешный
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Фотокарточка к записи добавлена',
                 ]);
        // Получаем путь файла из ответа
        $responseData = $response->json();
        $savedPhotoPath = str_replace(
            env('APP_URL') . '/',
            '',
            $responseData['notebook_photo']['photo_path'] // Доступ к photo_path
        ); 
        $savedPhotoFullPath = public_path($savedPhotoPath); // Получаем полный путь

        // Проверяем, что файл существует
        $this->assertTrue(
            file_exists($savedPhotoFullPath),
            'Файл не был сохранен в правильное место: ' . $savedPhotoFullPath
        );

        // Проверяем, что запись в БД создана
        $this->assertDatabaseHas('notebook_photos', [
            'notebook_id' => $notebook->id,
            'photo_path' => $responseData['notebook_photo']['photo_path'], // Доступ к photo_path
        ]);
    }

    public function test_index_returns_all_photos()
    {
        // Создаем связанный notebook
        $notebook = Notebook::factory()->create();

        // Создаем тестовые данные
        NotebookPhoto::factory()->count(5)->create([
            'notebook_id' => $notebook->id, // Указываем связанный notebook_id
        ]);

        // Отправляем GET-запрос к методу index
        $response = $this->getJson('/api/v1/notebook-photos');

        // Проверяем, что ответ успешный и содержит 5 элементов
        $response->assertStatus(200)
                 ->assertJsonCount(5);
    }

    public function test_destroy_notebook_photo()
    {
        // Создаем связанный notebook
        $notebook = Notebook::factory()->create();

        // Создаем тестовую запись
        $photo = NotebookPhoto::factory()->create([
            'notebook_id' => $notebook->id, // Указываем связанный notebook_id
        ]);

        // Отправляем DELETE-запрос
        $response = $this->deleteJson("/api/v1/notebook-photos/{$photo->id}");

        // Проверяем, что запись удалена
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'фотокарточка удалена',
                 ]);

        $this->assertDatabaseMissing('notebook_photos', [
            'id' => $photo->id,
        ]);
    }
}
