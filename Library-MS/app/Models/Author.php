<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     title="Author",
 *     required={"id", "name", "email"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of an author"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the author"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The email address of the author"
 *     ),
 * )
 */
class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
