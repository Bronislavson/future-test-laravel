<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NotebooksController;
use App\Http\Controllers\Api\V1\NotebookPhotosController;



// Версия API v1
Route::prefix('v1')->group(function () {
Route::apiResource('notebooks', NotebooksController::class);
Route::apiResource('notebook-photos', NotebookPhotosController::class);
});
