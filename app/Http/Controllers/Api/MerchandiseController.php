<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchandise;
use OpenApi\Annotations as OA;

/**
 * Class AuthController.
 * 
 * @author nikeisha.422024026@gmail.com
 */



/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Hallyu Haven API",
 *     description="API dokumentasi toko online Kpop merchandise",
 *     @OA\Contact(
 *         email="nikeisha.422024026@gmail.com"
 *     )
 * )
 */

class MerchandiseController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/merchandise",
     *     tags={"Merchandise"},
     *     summary="Get list of merchandise",
     *     description="Returns list of merchandise with optional filtering and pagination",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Filter by product name",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Pagination page number",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Merchandise::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 6);
        return response()->json($query->paginate($perPage));
    }

    /**
     * @OA\Post(
     *     path="/api/merchandise",
     *     tags={"Merchandise"},
     *     summary="Create a new merchandise item",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "stock"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="stock", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Merchandise created")
     * )
     */
    public function store(Request $request)
{
    $request->validate([
    'name' => 'required|string|max:255',
    'price' => 'required|numeric|min:0',
    'stock' => 'nullable|integer|min:0',
    ]);

    $merch = Merchandise::create([
        'name' => $request->name,
        'price' => $request->price,
        'description' => $request->description,
        'image' => $request->image,
        'stock' => $request->stock ?? 0
    ]);

    return response()->json($merch, 201);
}


    /**
     * @OA\Get(
     *     path="/api/merchandise/{id}",
     *     tags={"Merchandise"},
     *     summary="Get a single merchandise item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Merchandise found"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function show($id)
    {
        return Merchandise::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/merchandise/{id}",
     *     tags={"Merchandise"},
     *     summary="Update a merchandise item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated successfully")
     * )
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'price' => 'sometimes|numeric|min:0',
        'stock' => 'nullable|integer|min:0',
    ]);

    $merch = Merchandise::findOrFail($id);
    $data = $request->only(['name', 'description', 'price', 'stock', 'image']);

    $merch->update($data);

    return response()->json($merch);
}

    /**
     * @OA\Delete(
     *     path="/api/merchandise/{id}",
     *     tags={"Merchandise"},
     *     summary="Delete a merchandise item",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Item not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $merch = Merchandise::findOrFail($id);
        $merch->delete();

        return response()->json(['message' => 'Deleted successfully'], 204);
    }
}