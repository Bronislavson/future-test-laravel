<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotebookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|email|unique:notebooks,email',
            'phone' => 'required|string|unique:notebooks,phone',
            'date_of_birth' => 'nullable|date',
        ];
    }
}
