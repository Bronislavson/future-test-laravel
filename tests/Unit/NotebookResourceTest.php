<?php

namespace Tests\Unit;

use App\Models\Notebook;
use App\Http\Resources\Api\V1\NotebookResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class NotebookResourceTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_transforms_notebook_into_array()
    {
        // Создаём модель
        $notebook = Notebook::factory()->create();

        // Получаем ресурс
        $resource = new NotebookResource($notebook);

        // Преобразуем в массив
        $array = $resource->toArray(new Request());

        // Проверяем, что данные присутствуют в ответе
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('full_name', $array);
        $this->assertArrayHasKey('company', $array);
        $this->assertArrayHasKey('email', $array);
        $this->assertArrayHasKey('phone', $array);
        $this->assertArrayHasKey('date_of_birth', $array);
        $this->assertArrayHasKey('photos', $array);

        // Проверяем, что данные корректны
        $this->assertEquals($notebook->id, $array['id']);
        $this->assertEquals($notebook->full_name, $array['full_name']);
        $this->assertEquals($notebook->company, $array['company']);
    }

    /** @test */
    public function it_includes_photos_in_the_transformed_array()
    {
        $notebook = Notebook::factory()->create();
        $photo = $notebook->images()->create([
            'photo_path' => 'path/to/photo.jpg',
        ]);

        $resource = new NotebookResource($notebook);
        $array = $resource->toArray(new Request());

        // Проверяем, что фото присутствуют в ответе
        $this->assertArrayHasKey('photos', $array);
        $this->assertCount(1, $array['photos']);
        $this->assertEquals('/notebook_photos/photo.jpg', $array['photos'][0]['img']);
    }
}
