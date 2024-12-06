<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\NotebookResource;
use App\Http\Resources\Api\V1\NotebookCollection;
use Illuminate\Http\Request;
use App\Models\Notebook;
use OpenApi\Annotations as OA;
use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;



/**
 * @OA\Info(
 *     title="Notebooks API",
 *     version="1.0.0",
 *     description="API для управления записями в записной книжке",
 * )
 * @OA\Tag(
 *     name="Notebooks",
 *     description="Операции с записями в записной книжке"
 * )
 */
class NotebooksController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/notebooks",
     *     summary="Получение списка записей",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Количество записей на странице",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список записей успешно получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Информация о записной книжке",
     *                 @OA\Property(property="id", type="integer", description="Уникальный идентификатор записи", example=31),
     *                 @OA\Property(property="full_name", type="string", description="Полное имя пользователя", example="Bella Little"),
     *                 @OA\Property(property="company", type="string", description="Название компании пользователя", example="Hoppe Group"),
     *                 @OA\Property(property="email", type="string", format="email", description="Электронная почта пользователя", example="doconnell@example.com"),
     *                 @OA\Property(property="phone", type="string", description="Номер телефона пользователя", example="+19033972169"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения пользователя", example="2016-07-30"),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="array",
     *                     description="Список фотографий",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Идентификатор фотографии", example=13),
     *                         @OA\Property(property="img", type="string", format="uri", description="Путь к фотографии", example="/notebook_photos/ZIemeOuDIxpN4.jpg")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $notebooks = Notebook::paginate($request->limit);
        return new NotebookCollection($notebooks);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/notebooks",
     *     summary="Создание новой записи",
     *     tags={"Notebooks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "email", "phone"},
     *             @OA\Property(property="full_name", type="string", description="Полное имя"),
     *             @OA\Property(property="company", type="string", description="Название компании"),
     *             @OA\Property(property="email", type="string", format="email", description="Электронная почта"),
     *             @OA\Property(property="phone", type="string", description="Номер телефона"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Новая запись в книжке создана",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Новая запись в книжке создана"),
     *             @OA\Property(property="notebook", type="object",
     *                 required={"full_name", "email", "phone"},
     *                 @OA\Property(property="id", type="integer", description="Уникальный идентификатор записи", example=101),
     *                 @OA\Property(property="full_name", type="string", description="Полное имя"),
     *                 @OA\Property(property="company", type="string", description="Название компании"),
     *                 @OA\Property(property="email", type="string", format="email", description="Электронная почта"),
     *                 @OA\Property(property="phone", type="string", description="Номер телефона"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обнавления")
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreNotebookRequest $request)
    {
        $notebook = Notebook::create($request->validated());

        return response()->json([
            'message' => 'Новая запись в книжке создана',
            'notebook' => $notebook
        ], 201);
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/notebooks/{id}",
     *     summary="Получение записи по ID",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID записи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="запись успешно получена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Информация о записной книжке",
     *                 @OA\Property(property="id", type="integer", description="Уникальный идентификатор записи", example=31),
     *                 @OA\Property(property="full_name", type="string", description="Полное имя пользователя", example="Bella Little"),
     *                 @OA\Property(property="company", type="string", description="Название компании пользователя", example="Hoppe Group"),
     *                 @OA\Property(property="email", type="string", format="email", description="Электронная почта пользователя", example="doconnell@example.com"),
     *                 @OA\Property(property="phone", type="string", description="Номер телефона пользователя", example="+19033972169"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения пользователя", example="2016-07-30"),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="array",
     *                     description="Список фотографий",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", description="Идентификатор фотографии", example=13),
     *                         @OA\Property(property="img", type="string", format="uri", description="Путь к фотографии", example="/notebook_photos/ZIemeOuDIxpN4.jpg")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json([
                'status' => false,
                'message' => 'Такой записи в книжке не существует'
            ], 404);
        }
        return new NotebookResource($notebook);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/notebooks/{id}",
     *     summary="Обновление записи",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID записи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "email", "phone"},
     *             @OA\Property(property="full_name", type="string", description="Полное имя"),
     *             @OA\Property(property="company", type="string", description="Название компании"),
     *             @OA\Property(property="email", type="string", format="email", description="Электронная почта"),
     *             @OA\Property(property="phone", type="string", description="Номер телефона"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Запись обновилась",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Запись обновилась"),
     *             @OA\Property(property="notebook", type="object",
     *                 required={"full_name", "email", "phone"},
     *                 @OA\Property(property="id", type="integer", description="Уникальный идентификатор записи", example=31),
     *                 @OA\Property(property="full_name", type="string", description="Полное имя"),
     *                 @OA\Property(property="company", type="string", description="Название компании"),
     *                 @OA\Property(property="email", type="string", format="email", description="Электронная почта"),
     *                 @OA\Property(property="phone", type="string", description="Номер телефона"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", description="Дата рождения"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обнавления")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function update(UpdateNotebookRequest $request, string $id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json([
                'message' => 'Данная запись не найдена'
            ], 404);
        }

        $notebook->update($request->validated());

        return response()->json([
            'message' => 'Запись обновилась',
            'notebook' => $notebook,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/notebooks/{id}",
     *     summary="Удаление записи",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID записи",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Запись удалена"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Запись не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $notebook = Notebook::find($id);
        if (!$notebook) {
            return response()->json([
                'status' => false,
                'message' => 'Запись не найдена'
            ], 404);
        }
        $notebook->delete(); // отдельно фото не удяляем, так как при создании использовали onDelete('cascade')
        return response()->json([
            'message' => 'Запись и привязанные к ней фото удалены',
            'status' => true,
        ], 204);
    }
}
