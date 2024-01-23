<?php

namespace App\v1\Http\Controllers;

use App\v1\Models\Item;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{

    /**
     * @OA\Get(
     *    path="/items",
     *    operationId="indexItem",
     *    tags={"Items"},
     *    summary="Get list of items",
     *    description="Get list of items",
     *     @OA\Parameter(name="limit", in="query", description="limit", required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="page", in="query", description="the page number", required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(name="order", in="query", description="order by category_id 'asc' or 'desc'", required=false,
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

    public function allItems(Request $request): JsonResponse
    {
        $limit = $request->limit ?: 15;
        $order = $request->order == 'asc' ? 'asc' : 'desc';
        try {
            $items = Item::orderBy('category_id', $order)
                ->select('id', 'category_id', 'title', 'author', 'year', 'state', 'about_state', 'price', 'image', 'note')
                ->where('isActive', 1)
                ->paginate($limit);
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $items,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/items/{id}",
     *    operationId="showItem",
     *    tags={"Items"},
     *    summary="Get Item Detail",
     *    description="Get Detail Detail",
     *    @OA\Parameter(name="id", in="path", description="Id of Detail", required=true,
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
    public function getItem($id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $item = Item::find($id);
            if ($item === null) {
                return response([], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $item,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/items",
     *      operationId="storeItem",
     *      tags={"Items"},
     *      summary="Store item in DB",
     *      description="Store item in DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"category_id"},
     *            @OA\Property(property="category_id", type="integer", format="integer", example="1"),
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
    public function createItem(Request $request): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $item = Item::create($request->all());
            if (!$item) {
                return response([], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $item,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/items/{id}",
     *      operationId="updateItem",
     *      tags={"Items"},
     *      summary="Update item in DB",
     *      description="Update item in DB",
     *      @OA\Parameter(name="id", in="path", description="Id of Item", required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"parent_id", "isActive", "isDeleted", "isActive", "isDeleted"},
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
    public function updateItem(Request $request, $id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $item = Item::find($id);
            if ($item === null) {
                return response([], 400);
            }
            $item->update($request->all());
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $item,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/items/{id}",
     *     operationId="deleteItem",
     *     summary="Delete a item",
     *     tags={"Items"},
     *     description="Delete item from DB",
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
    public function deleteItem($id): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $item = Item::find($id);
            if ($item === null) {
                return response([], 400);
            }
            $item->isDeleted = 1;
            $item->save();
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $item,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/items/{id}",
     *     operationId="uploadImages",
     *     summary="uploadImages",
     *     tags={"Items"},
     *     description="add image to item",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="adding image to item",
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
    public function uploadImage(Request $request, $itemId): Application|\Illuminate\Http\Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $item = Item::find($itemId);
            if ($item === null) {
                return response([], 400);
            }

            $arrFilesNameResponse = array();
            if($request->hasFile('image')) {
                foreach ($request->file('image') as $index=>$file) {
                    $originalName = $file->getClientOriginalName();
                    $arrOriginalName = explode('.', $originalName);
                    $newName = $itemId . '_' . $index+1 . '.' . $arrOriginalName[1];
                    $file->move(public_path() . '/storage/images/', $newName);
                    $arrFilesNameResponse[] = $newName;
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'data' => $item,
            'files_uploaded' => $arrFilesNameResponse,
            'message' => 'Succeed'
        ], Response::HTTP_OK);
    }
}

