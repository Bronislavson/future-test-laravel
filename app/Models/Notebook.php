<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="Notebook",
 *     type="object",
 *     title="Notebook",
 *     description="Модель записной книжки",
 *     @OA\Property(property="id", type="integer", description="Уникальный идентификатор записи", example=31),
 *     @OA\Property(property="full_name", type="string", description="Полное имя пользователя", example="Bella Little"),
 *     @OA\Property(property="company", type="string", description="Название компании пользователя", example="Hoppe Group"),
 *     @OA\Property(property="email", type="string", format="email", description="Электронная почта пользователя", example="doconnellexample.com"),
 *     @OA\Property(property="phone", type="string", description="Номер телефона пользователя", example="+19033972169"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения пользователя", example="2016-07-30"),
 *     @OA\Property(
 *         property="photos",
 *         type="array",
 *         description="Список фотографий",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="id", type="integer", description="Идентификатор фотографии", example=13),
 *             @OA\Property(property="img", type="string", format="uri", description="Путь к фотографии", example="/notebook_photos/ZIemeOuDIxpN4.jpg")
 *         )
 *     )
 * )
 */

class Notebook extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'full_name',
        'company',
        'email',
        'phone',
        'date_of_birth'
    ];
    
    public function images()
    {
        return $this->hasMany(NotebookPhoto::class);
    }
}
