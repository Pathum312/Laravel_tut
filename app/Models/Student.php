<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 * @method static select(string $string, string $string1, string $string2, string $string3)
 * @method static find(int $id)
 */
class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'firstName', 'lastName', 'email', 'age'
    ];
}
