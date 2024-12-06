<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\NotebookPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


/**
 * @OA\Tag(
 *     name="NotebookPhotos",
 *     description="Операции с фотографиями"
 * )
 */
class NotebookPhotosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/notebook-photos",
     *     summary="Получение списка фотографий",
     *     tags={"Notebook Photos"},
     *     @OA\Response(
     *         response=200,
     *         description="Список фотографий",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/NotebookPhoto")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $notebookPhoto = NotebookPhoto::all();
        return response($notebookPhoto, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebook-photos",
     *     summary="Загрузка фотографии",
     *     tags={"Notebook Photos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="photo",
     *                     type="file"
     *                 ),
     *                 @OA\Property(
     *                     property="notebook_id",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Фотокарточка к записи добавлена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="notebook_photo", ref="#/components/schemas/NotebookPhoto")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $file = $request->file('photo');
        $name = Str::random(13);
        $url = Storage::putFileAs('notebook_photos', $file, name:$name . '.' . $file->extension());

        $notebookPhoto = NotebookPhoto::create([
            'notebook_id' => $request->input('notebook_id'),
            'photo_path' => env('APP_URL') . '/' . $url,
        ]);

        return response()->json([
            'message' => 'Фотокарточка к записи добавлена',
            'notebook_photo' => $notebookPhoto,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/notebook-photos/{id}",
     *     summary="Получение фотографии по ID",
     *     tags={"Notebook Photos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Фотография найдена",
     *         @OA\JsonContent(ref="#/components/schemas/NotebookPhoto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Фотография не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $notebookPhoto = NotebookPhoto::find($id);
        if (!$notebookPhoto) {
            return response()->json ([
            'status' => false,
            'message' =>'Данной фотокарточки не существует'
            ], 404);
        }
        return response($notebookPhoto);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notebook-photos/{id}",
     *     summary="Удаление фотографии по ID",
     *     tags={"Notebook Photos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Фотография удалена",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Фотография не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $notebookPhoto = NotebookPhoto::find($id);
        if (!$notebookPhoto) {
            return response()->json ([
            'status' => false,
            'message' =>'фотокарточка не найдена'
            ], 404);
        }
        $notebookPhoto -> delete();
        return response()->json ([
            'status' => true,
            'message' =>'фотокарточка удалена'
        ], 200);
    }
}
