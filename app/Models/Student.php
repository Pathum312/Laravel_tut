<?php

namespace App\Models;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * @method static findOrfail(array|Application|Request|string|null $request)
 * @method static create(array $all)
 * @method static find(array|Application|Request|string|null $request)
 */
class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'firstName', 'lastName', 'email', 'age'
    ];
}
