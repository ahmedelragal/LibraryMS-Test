<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use Illuminate\Http\Request;

use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *     title="Library Management API",
 *     version="1.0.0",
 *     description="API documentation for the Library Management System.",
 *     @OA\Contact(
 *         email="ahmed.elragal02@gmail.com"
 *     )
 * )
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     operationId="getAuthorsList",
     *     tags={"Authors"},
     *     summary="Get list of authors",
     *     description="Returns list of authors",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Author")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No authors found"
     *     )
     * )
     */
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     summary="Get list of all authors",
     *     @OA\Response(
     *         response=200,
     *         description="A list of all authors",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Author"))
     *     )
     * )
     */
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     summary="Create a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(property="message", type="string", example="Author created successfully")
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
    public function store(AuthorStoreRequest $request)
    {
        $author = Author::create($request->validated());
        return $this->successResponse(['message' => 'Author created successfully'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{id}",
     *     summary="Retrieve a specific author by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author found",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Author not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $author = Author::find($id);
        if ($author) {
            return $this->successResponse($author, 200);
        }
        return $this->errorResponse('Author not found', 404);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{id}",
     *     summary="Update a specific author by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Author Name"),
     *             @OA\Property(property="email", type="string", example="updatedemail@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Author updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Author not found")
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
    public function update(AuthorUpdateRequest $request, string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return $this->errorResponse('Author not found', 404);
        }
        if ($request->has('email') && $request->email !== $author->email) {
            Log::info("Author {$author->name}'s email changed to {$request->email}");
        }
        if ($request->only(['name', 'email'])) {
            $author->update($request->validated());
            return $this->successResponse(['message' => 'Author updated successfully'], 200);
        }
    }



    /**
     * @OA\Delete(
     *     path="/api/authors/{id}",
     *     summary="Delete a specific author by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Author deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="Author not found")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return $this->errorResponse('Author not found', 404);
        }
        $author->delete();
        return $this->successResponse(['message' => 'Author deleted successfully'], 200);
    }
}
