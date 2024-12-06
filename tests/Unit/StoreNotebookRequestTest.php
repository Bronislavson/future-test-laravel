<?php

namespace Tests\Unit;

use App\Http\Requests\StoreNotebookRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNotebookRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_validates_request_data_correctly()
    {
        // Получаем правила валидации из `StoreNotebookRequest`
        $rules = (new StoreNotebookRequest())->rules();

        // Тестируем валидные данные
        $validData = [
            'full_name' => 'fff Doe',
            'company' => 'Example Inc.',
            'email' => 'fff.doe@example.com',
            'phone' => '3214567890',
            'date_of_birth' => '1990-01-01',
        ];

        $validator = Validator::make($validData, $rules);
        $this->assertTrue($validator->passes(), 'Validation should pass for valid data.');

        // Тестируем невалидные данные
        $invalidData = [
            'full_name' => '', // Пустое поле
            'email' => 'invalid-email', // Невалидный email
            'phone' => null, // Пропущенный обязательный телефон
        ];

        $validator = Validator::make($invalidData, $rules);
        $this->assertFalse($validator->passes(), 'Validation should fail for invalid data.');

        // Проверяем конкретные ошибки валидации
        $this->assertArrayHasKey('full_name', $validator->errors()->messages());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
    }
}
