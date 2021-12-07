<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Student;

Route::get('/students', function () {
    return Student::all();
});
