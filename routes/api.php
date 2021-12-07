<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use \App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [StudentController::class, 'get']);

Route::post('/students', [StudentController::class, 'store']);

Route::put('/students', [StudentController::class, 'update']);

Route::delete('/students/{id}', [StudentController::class, 'destroy']);

Route::get('/students/{id}', [StudentController::class, 'getById']);
