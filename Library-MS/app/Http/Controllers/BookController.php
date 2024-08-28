<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;

use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get list of all books",
     *     @OA\Response(
     *         response=200,
     *         description="A list of all books",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     )
     * )
     */
    public function index()
    {
        $books = Book::all();
        return $this->successResponse($books, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","isbn","published_date","author_id"},
     *             @OA\Property(property="title", type="string", example="Sample Book"),
     *             @OA\Property(property="isbn", type="string", example="1234567890"),
     *             @OA\Property(property="published_date", type="string", format="date", example="2024-01-01"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Book created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="Validation errors")
     *         )
     *     )
     * )
     */
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        return $this->successResponse(['message' => 'Book created successfully'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Retrieve a specific book by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book found",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if ($book) {
            return $this->successResponse($book, 200);
        }
        return $this->errorResponse('Book not found', 404);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Update a specific book by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Book Title"),
     *             @OA\Property(property="isbn", type="string", example="0987654321"),
     *             @OA\Property(property="published_date", type="string", format="date", example="2024-05-01"),
     *             @OA\Property(property="author_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Book updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=422),
     *             @OA\Property(property="message", type="string", example="Validation errors")
     *         )
     *     )
     * )
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return $this->errorResponse('Book not found', 404);
        }

        if ($request->only(['title', 'isbn', 'published_date', 'author_id'])) {
            $book->update($request->validated());
            return $this->successResponse(['message' => 'Book updated successfully'], 200);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Delete a specific book by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Book deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Book not found")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return $this->errorResponse('Book not found', 404);
        }
        $book->delete();
        return $this->successResponse(['message' => 'Book deleted successfully'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/books/search",
     *     summary="Search for books by title",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Books matching the search criteria",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Book"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No books found matching the search criteria",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="No books found")
     *         )
     *     )
     * )
     */
    public function search(Request $request)
    {
        $title = $request->query('title');
        if (!$title) {
            return $this->errorResponse('Title parameter is required', 400);
        }

        $books = Book::where('title', 'like', '%' . $title . '%')->get();
        if ($books->isEmpty()) {
            return $this->errorResponse('Book not found', 404);
        }

        return $this->successResponse($books, 200);
    }
}
