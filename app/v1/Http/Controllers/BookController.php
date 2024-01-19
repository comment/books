<?php

namespace App\v1\Http\Controllers;

use App\v1\Models\Book;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{

    /**
     * @OA\Get(
     *    path="/books",
     *    operationId="indexBook",
     *    tags={"Books"},
     *    summary="Get list of books",
     *    description="Get list of books",
     *     @OA\Parameter(name="limit", in="query", description="limit", required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="page", in="query", description="the page number", required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="order", in="query", description="order by title 'asc' or 'desc'", required=false,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(response=200, description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *         )
     *     ),
     * )
     */

    public function allBooks(Request $request): JsonResponse
    {
        $limit = $request->limit ?: 15;
        $order = $request->order == 'asc' ? 'asc' : 'desc';
        try {
            $books = Book::orderBy('title', $order)
                ->select('id', 'title', 'author', 'year', 'description')
                ->where('isActive', 1)
                ->paginate($limit);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $books,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/books/{id}",
     *    operationId="showBook",
     *    tags={"Books"},
     *    summary="Get Book Detail",
     *    description="Get Book Detail",
     *    @OA\Parameter(name="id", in="path", description="Id of Book", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *          @OA\Property(property="status", type="integer", example="200"),
     *          @OA\Property(property="data",type="object")
     *          )
     *     )
     * )
     */
    public function getBook($id): \Illuminate\Foundation\Application|\Illuminate\Http\Response|JsonResponse|Application|ResponseFactory
    {
        try {
            $book = Book::find($id);
            if ($book === null) {
                return response([], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $book,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/books",
     *      operationId="storeBook",
     *      tags={"Books"},
     *      summary="Store book in DB",
     *      description="Store book in DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "author", "year", "description"},
     *            @OA\Property(property="title", type="string", format="string", example="Harry Potter"),
     *            @OA\Property(property="author", type="string", format="string", example="Sergey Abraztsou"),
     *            @OA\Property(property="year", type="string", format="string", example="1988"),
     *            @OA\Property(property="description", type="string", format="string", example="Cool Story ab'ut love and magic!"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object")
     *          )
     *     )
     * )
     */
    public function createBook(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|JsonResponse|Application|ResponseFactory
    {
        try {
            $book = Book::create($request->all());
            if (!$book) {
                return response([], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $book,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/books/{id}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      summary="Update book in DB",
     *      description="Update book in DB",
     *      @OA\Parameter(name="id", in="path", description="Id of Book", required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "author", "year", "description"},
     *            @OA\Property(property="title", type="string", format="string", example="Harry Potter"),
     *            @OA\Property(property="author", type="string", format="string", example="Sergey Abraztsou"),
     *            @OA\Property(property="year", type="string", format="string", example="1988"),
     *            @OA\Property(property="description", type="string", format="string", example="Cool Story ab'ut love and magic!"),
     *            @OA\Property(property="isActive", type="integer", format="integer", example="0"),
     *            @OA\Property(property="isDeleted", type="integer", format="integer", example="1"),
     *         ),
     *      ),
     *      @OA\Response(
     *           response=200, description="Success",
     *           @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="data",type="object")
     *           )
     *      )
     * )
     */
    public function updateBook(Request $request, $id): \Illuminate\Foundation\Application|\Illuminate\Http\Response|JsonResponse|Application|ResponseFactory
    {
        try {
            $book = Book::find($id);
            if ($book === null) {
                return response([], 400);
            }
            $book->update($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $book,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/books/{id}",
     *     operationId="deleteBook",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     description="Delete book from DB",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id that to be updated isDeleted = 1",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *           response=200, description="Success",
     *           @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="200"),
     *              @OA\Property(property="data",type="object")
     *           )
     *      )
     * )
     */
    public function deleteBook($id): \Illuminate\Foundation\Application|\Illuminate\Http\Response|JsonResponse|Application|ResponseFactory
    {
        try {
            $book = Book::find($id);
            if ($book === null) {
                return response([], 400);
            }
            $book->isDeleted = 1;
            $book->save();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $book,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }
}
