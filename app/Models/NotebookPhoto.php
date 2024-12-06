<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 *     schema="NotebookPhoto",
 *     type="object",
 *     title="NotebookPhoto",
 *     required={"notebook_id", "photo_path"},
 *     @OA\Property(property="id", type="integer", description="Идентификатор", example=31),
 *     @OA\Property(property="notebook_id", type="integer", description="Идентификатор записной книжки", example=22),
 *     @OA\Property(property="photo_path", type="string", description="Путь к фотографии"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обновления")
 * )
 */
class NotebookPhoto extends Model
{
    use HasFactory;
    protected $quarded = ['id'];
    protected $fillable = ['photo_path', 'notebook_id'];
}
