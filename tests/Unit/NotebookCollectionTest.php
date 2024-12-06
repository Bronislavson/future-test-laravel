<?php

namespace Tests\Unit;

use App\Models\Notebook;
use App\Http\Resources\Api\V1\NotebookCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class NotebookCollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_transforms_collection_into_array()
    {
        // Создаём несколько записей в базе данных (для пагинации)
        $notebooks = Notebook::factory()->count(3)->create();

        // Используем пагинацию для получения записей
        $paginatedNotebooks = Notebook::paginate(3); // Пагинируем записи, 3 элемента на странице

        // Преобразуем пагинированный результат в коллекцию
        $collection = new NotebookCollection($paginatedNotebooks);

        // Преобразуем в массив
        $array = $collection->toArray(new Request());

        // Проверяем, что данные в коллекции присутствуют
        $this->assertArrayHasKey('data', $array);
        $this->assertCount(3, $array['data']); // Проверяем, что 3 элемента в данных
        $this->assertArrayHasKey('total', $array); // Проверяем, что есть 'total'
        $this->assertEquals(3, $array['total']); // Проверяем, что total = 3
    }
}
