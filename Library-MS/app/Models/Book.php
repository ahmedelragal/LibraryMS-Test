<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     title="Book",
 *     required={"id", "title", "isbn", "published_date", "author_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of a book"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="The title of the book"
 *     ),
 *     @OA\Property(
 *         property="isbn",
 *         type="string",
 *         description="The ISBN of the book"
 *     ),
 *     @OA\Property(
 *         property="published_date",
 *         type="string",
 *         format="date",
 *         description="The published date of the book"
 *     ),
 *     @OA\Property(
 *         property="author_id",
 *         type="integer",
 *         description="The ID of the author associated with the book"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         ref="#/components/schemas/Author",
 *         description="Details of the author who wrote the book"
 *     ),
 * )
 */
class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'isbn', 'published_date', 'author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
