<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Merchandise;
use OpenApi\Annotations as OA;

class MerchandiseController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/merchandise",
     * operationId="getMerchandiseList",
     * tags={"Merchandise"},
     * summary="Get list of merchandise",
     * description="Returns a paginated list of merchandise with filtering and sorting options.",
     * @OA\Parameter(
     * name="_page",
     * in="query",
     * description="Page number",
     * required=false,
     * @OA\Schema(type="integer", default=1)
     * ),
     * @OA\Parameter(
     * name="_limit",
     * in="query",
     * description="Number of items per page",
     * required=false,
     * @OA\Schema(type="integer", default=10)
     * ),
     * @OA\Parameter(
     * name="_search",
     * in="query",
     * description="Search by merchandise name",
     * required=false,
     * @OA\Schema(type="string")
     * ),
     * @OA\Parameter(
     * name="_sort_by",
     * in="query",
     * description="Sort by criteria (e.g., 'latest', 'name_asc', 'price_desc')",
     * required=false,
     * @OA\Schema(type="string", example="latest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent()
     * )
     * )
     */

    public function index(Request $request)
    {
        $page = (int) ($request->_page ?? 1);
        $limit = (int) ($request->_limit ?? 8);
        $offset = ($page - 1) * $limit;

        $query = Merchandise::query();

        if ($request->_type) {
            $query->where('type', $request->_type);
        }

        if ($request->_price_range) {
        switch ($request->_price_range) {
            case 'under_100':
                $query->where('price', '<', 100000);
                break;
            case '100_500':
                $query->whereBetween('price', [100000, 500000]);
                break;
            case '501_1000':
                $query->whereBetween('price', [501000, 1000000]);
                break;
            case 'above_1000':
                $query->where('price', '>', 1000000);
                break;
            }
        }

        if ($request->_search) {
            $query->where('name', 'like', '%' . $request->_search . '%');
        }

        if ($request->_tags) {
            $query->where('tags', 'like', '%' . $request->_tags . '%');
        }

        if ($request->_sort_by) {
            switch ($request->_sort_by) {
                case 'name_asc':
                    $query->orderBy('name', 'ASC');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'DESC');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'DESC');
                    break;
                default:
                    $query->orderBy('created_at', 'DESC');
                    break;
            }
        }

        $products = $query->offset($offset)->limit($limit)->get();
        $total = $query->count();

        return response()->json([
            'filter' => $request->all(),
            'products' => $products,
            'products_count_total' => $total,
            'products_count_start' => ($total > 0) ? $offset + 1 : 0,
            'products_count_end' => ($total > 0) ? $offset + count($products) : 0
        ], 200);
    }
/**
     * @OA\Get(
     * path="/api/slider-merchandise",
     * operationId="getSliderMerchandise",
     * tags={"Merchandise"},
     * summary="Get merchandise for slider",
     * description="Returns a specific list of merchandise items for a slider feature.",
     * @OA\Response(
     * response=200,
     * description="Slider merchandise loaded successfully",
     * @OA\JsonContent()
     * )
     * )
     */
    public function slider()
    {
        $ids = [2, 5, 1];
        $idsStr = implode(',', $ids);

        $products = Merchandise::whereIn('id', $ids)
            ->orderByRaw("FIELD(id, $idsStr)")
            ->get();

        return response()->json([
            'products' => $products
        ]);
    }

     /**
     * @OA\Get(
     * path="/api/merchandise/{id}",
     * operationId="getMerchandiseById",
     * tags={"Merchandise"},
     * summary="Get a single merchandise",
     * description="Returns the details of a specific merchandise item.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the merchandise",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent()
     * ),
     * @OA\Response(
     * response=404,
     * description="Merchandise not found"
     * )
     * )
     */

    public function show($id)
    {
        $merchandise = Merchandise::find($id);

        if (!$merchandise) {
            return response()->json(['message' => 'Merchandise not found'], 404);
        }

        return response()->json($merchandise);
    }

    /**
     * @OA\Post(
     * path="/api/merchandise",
     * operationId="storeMerchandise",
     * tags={"Merchandise"},
     * summary="Create a new merchandise",
     * description="Stores a new merchandise item with an image upload.",
     * @OA\RequestBody(
     * required=true,
     * description="Merchandise data",
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "description", "price", "image"},
     * @OA\Property(property="name", type="string", example="Cool T-Shirt"),
     * @OA\Property(property="description", type="string", example="A very cool t-shirt made of cotton."),
     * @OA\Property(property="price", type="number", format="float", example=150000),
     * @OA\Property(property="image", type="string", format="binary", description="Image file (jpeg, png, jpg, gif, svg).")
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Merchandise created successfully",
     * @OA\JsonContent()
     * ),
     * @OA\Response(
     * response=400,
     * description="Validation error"
     * )
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $imagePath = $request->file('image')->store('merchandise', 'public');

        $merchandise = Merchandise::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return response()->json($merchandise, 201);
    }


    /**
     * @OA\Put(
     * path="/api/merchandise/{id}",
     * operationId="updateMerchandise",
     * tags={"Merchandise"},
     * summary="Update an existing merchandise",
     * description="Updates a merchandise item. Note: Use POST with _method=PUT for form-data.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the merchandise to update",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Merchandise data to update. Image update is not included here but can be handled separately.",
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * @OA\Property(property="name", type="string", example="Updated T-Shirt"),
     * @OA\Property(property="description", type="string", example="An updated description."),
     * @OA\Property(property="price", type="number", format="float", example=175000)
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Merchandise updated successfully",
     * @OA\JsonContent()
     * ),
     * @OA\Response(
     * response=404,
     * description="Merchandise not found"
     * ),
     * @OA\Response(
     * response=400,
     * description="Validation error"
     * )
     * )
     */

    public function update(Request $request, $id)
    {
        $merchandise = Merchandise::find($id);

        if (!$merchandise) {
            return response()->json(['message' => 'Merchandise not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $merchandise->update($request->all());

        return response()->json($merchandise);
    }

      /**
     * @OA\Delete(
     * path="/api/merchandise/{id}",
     * operationId="deleteMerchandise",
     * tags={"Merchandise"},
     * summary="Delete a merchandise",
     * description="Deletes a specific merchandise item and its associated image.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the merchandise to delete",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Merchandise deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Merchandise deleted successfully")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Merchandise not found"
     * )
     * )
     */

    public function destroy($id)
    {
        $merchandise = Merchandise::find($id);

        if (!$merchandise) {
            return response()->json(['message' => 'Merchandise not found'], 404);
        }

        Storage::disk('public')->delete($merchandise->image);
        $merchandise->delete();

        return response()->json(['message' => 'Merchandise deleted successfully']);
    }
}
