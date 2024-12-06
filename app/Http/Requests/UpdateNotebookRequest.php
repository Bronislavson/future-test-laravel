<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotebookRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('id'); // Берем ID из маршрута

        return [
            'full_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|unique:notebooks,email,' . $id,
            'phone' => 'required|string|unique:notebooks,phone,' . $id,
            'date_of_birth' => 'nullable|date',
        ];
    }
}
