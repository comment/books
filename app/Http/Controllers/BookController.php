<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description"
 * )
 *
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get a list of books",
     *     tags={"Books"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
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
