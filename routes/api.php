<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Student
Route::apiResource('students', 'App\Http\Controllers\API\StudentController');
Route::put('students', 'App\Http\Controllers\API\StudentController@update');
