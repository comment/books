<?php

namespace App\v1\Http\Controllers;

use App\v1\Models\Category;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\v1\Traits\BuildTree;

class CategoryController extends Controller
{

    use BuildTree;

    /**
     * @OA\Get(
     *    path="/categories",
     *    operationId="indexCategory",
     *    tags={"Categories"},
     *    summary="Get list of categories",
     *    description="Get list of categories",
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

    public function allCategories(Request $request): JsonResponse
    {
        //dd($this::buildTree(Category::all()->toArray()));
        $limit = $request->limit ?: 15;
        $order = $request->order == 'asc' ? 'asc' : 'desc';
        try {
            $categories = Category::orderBy('title', $order)
                ->select('id', 'title', 'parent_id')
                ->where('isActive', 1)
                ->paginate($limit);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $categories,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/categories/{id}",
     *    operationId="showCategory",
     *    tags={"Categories"},
     *    summary="Get Category Detail",
     *    description="Get Category Detail",
     *    @OA\Parameter(name="id", in="path", description="Id of Category", required=true,
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
    public function getCategory($id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $category = Category::find($id);
            if ($category === null) {
                return response([], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $category,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/categories",
     *      operationId="storeCategory",
     *      tags={"Categories"},
     *      summary="Store category in DB",
     *      description="Store category in DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "parent_id"},
     *            @OA\Property(property="title", type="string", format="string", example="Спорт"),
     *            @OA\Property(property="parent_id", type="integer", format="integer", example="1"),
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
    public function createCategory(Request $request): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $category = Category::create($request->all());
            if (!$category) {
                return response([], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $category,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/categories/{id}",
     *      operationId="updateCategory",
     *      tags={"Categories"},
     *      summary="Update category in DB",
     *      description="Update category in DB",
     *      @OA\Parameter(name="id", in="path", description="Id of Category", required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "parent_id", "isActive", "isDeleted"},
     *            @OA\Property(property="title", type="string", format="string", example="Туризм"),
     *            @OA\Property(property="parent_id", type="integer", format="integer", example="2"),
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
    public function updateCategory(Request $request, $id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $category = Category::find($id);
            if ($category === null) {
                return response([], 400);
            }
            $category->update($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $category,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     operationId="deleteCategory",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     description="Delete category from DB",
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
    public function deleteCategory($id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $category = Category::find($id);
            if ($category === null) {
                return response([], 400);
            }
            $category->isDeleted = 1;
            $category->save();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $category,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }
}
