<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notebook;

class NotebooksControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_returns_paginated_results()
    {
        // Создаем записи в базе данных
        Notebook::factory()->count(15)->create();

        // Делаем GET-запрос к конечной точке
        $response = $this->getJson('/api/v1/notebooks?limit=5');

        // Утверждаем, что запрос успешен
        $response->assertStatus(200);

        // Утверждаем, что вернулось 5 записей
        $response->assertJsonCount(5, 'data');

        // Проверяем структуру ответа
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'full_name', 'company', 'email', 'phone', 'date_of_birth', // Укажите поля ресурса
                ],
            ],
            'links',
            'meta',
        ]);
    }

    public function test_store_creates_notebook_entry()
    {
        // Подготовка данных
        $data = [
            'full_name' => 'John Doe',
            'company' => 'Example Inc.',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'date_of_birth' => '1990-01-01',
        ];

        // Делаем POST-запрос к конечной точке
        $response = $this->postJson('/api/v1/notebooks', $data);

        // Проверяем, что запись была добавлена в базу
        $this->assertDatabaseHas('notebooks', [
            'full_name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        // Утверждаем, что ответ содержит ожидаемые данные
        $response->assertJsonFragment([
            'message' => 'Новая запись в книжке создана',
        ]);
    }

    public function test_show_returns_notebook_entry()
    {
        // Создаем запись
        $notebook = \App\Models\Notebook::factory()->create();

        // Делаем GET-запрос
        $response = $this->getJson("/api/v1/notebooks/{$notebook->id}");

        // Утверждаем, что запрос успешен
        $response->assertStatus(200);

        // Проверяем, что возвращены корректные данные
        $response->assertJsonFragment([
            'id' => $notebook->id,
            'full_name' => $notebook->full_name,
        ]);
    }

    public function test_show_returns_404_if_not_found()
    {
        // Делаем запрос к несуществующему ресурсу
        $response = $this->getJson('/api/v1/notebooks/999');

        // Утверждаем, что возвращен статус 404
        $response->assertStatus(404);

        // Утверждаем, что сообщение об ошибке корректное
        $response->assertJsonFragment([
            'message' => 'Такой записи в книжке не существует',
        ]);
    }

    public function test_update_modifies_notebook_entry()
    {
        // Создаем запись
        $notebook = Notebook::factory()->create();

        // Подготовка данных для обновления
        $data = [
            'full_name' => 'Jane Doe',
            'email' => 'sdf.doe@example.com',
            'phone' => '1234567890',
        ];

        // Делаем PATCH-запрос
        $response = $this->patchJson("/api/v1/notebooks/{$notebook->id}", $data);

        // Утверждаем, что запрос успешен
        $response->assertStatus(200);

        // Утверждаем, что данные обновлены
        $this->assertDatabaseHas('notebooks', [
            'id' => $notebook->id,
            'full_name' => 'Jane Doe',
            'email' => 'sdf.doe@example.com',
            'phone' => '1234567890',
        ]);
    }

    public function test_update_returns_404_if_not_found()
    {
        // Делаем PATCH-запрос к несуществующей записи
        $response = $this->patchJson('/api/v1/notebooks/999', [
            'full_name' => 'Test User',
            'email' => 'dsa.doe@example.com',
            'phone' => '0987654321',
        ]);

        // Утверждаем, что возвращен статус 404
        $response->assertStatus(404);

        // Проверяем сообщение
        $response->assertJsonFragment([
            'message' => 'Данная запись не найдена',
        ]);
    }

    public function test_destroy_deletes_notebook_entry()
    {
        // Создаем запись
        $notebook = Notebook::factory()->create();

        // Делаем DELETE-запрос
        $response = $this->deleteJson("/api/v1/notebooks/{$notebook->id}");

        // Утверждаем, что запрос успешен
        $response->assertStatus(204);

        // Проверяем, что запись удалена
        $this->assertDatabaseMissing('notebooks', [
            'id' => $notebook->id,
        ]);
    }

    public function test_destroy_returns_404_if_not_found()
    {
        // Делаем DELETE-запрос к несуществующей записи
        $response = $this->deleteJson('/api/v1/notebooks/999');

        // Утверждаем, что возвращен статус 404
        $response->assertStatus(404);

        // Проверяем сообщение
        $response->assertJsonFragment([
            'message' => 'Запись не найдена',
        ]);
    }
}
