<?php

namespace App\v1\Http\Controllers;

use App\v1\Models\Book;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

#[OA\Get(
    path: "/books",
    summary: "List all books",
    security: [
        [
            'bearerAuth' => []
        ]
    ],
    tags: ["Admin"],
    responses: [
        new OA\Response(response: Response::HTTP_OK, description: "users retrieved success"),
        new OA\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized"),
        new OA\Response(response: Response::HTTP_NOT_FOUND, description: "not found"),
        new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
    ]
)]
    public function index()
    {
        try {
            $posts = Book::all();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Show a book",
     *     tags={"Book"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function show($id)
    {
        try {
            $posts = Book::find($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    #[OA\Post(
        path: "/books",
        summary: "Create Book",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        requestBody: new OA\RequestBody(required: true,
            content: new OA\MediaType(mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(required: ["title", "author", "year", "description"],
                    properties: [
                        new OA\Property(property: 'title', description: "Book title", type: "string"),
                        new OA\Property(property: 'author', description: "Author", type: "string"),
                        new OA\Property(property: 'year', description: "Year", type: "string"),
                        new OA\Property(property: 'description', description: "Short description", type: "string"),
                        ]
                ))),
        tags: ["Admin"],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: "Register Successfully"),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: "Unprocessable entity"),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: "Bad Request"),
            new OA\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function store(Request $request)
    {
        try {
            $posts = Book::create($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        try {
            $posts = Book::find($id)
                ->update($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        try {
            $posts = Book::destroy($id);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $posts,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }
}
