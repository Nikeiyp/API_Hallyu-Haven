<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\Merchandise;
use OpenApi\Annotations as OA;

class MerchandiseController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/merchandise",
     *     tags={"merchandise"},
     *     summary="Get list of merchandise",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Parameter(name="_page", in="query", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Parameter(name="_limit", in="query", required=true, @OA\Schema(type="integer", example=10)),
     *     @OA\Parameter(name="_search", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Parameter(name="_sort_by", in="query", required=false, @OA\Schema(type="string", example="latest")),
     * )
     */
   
     public function index(Request $request)
    {
        $page = (int) ($request->_page ?? 1);
        $limit = (int) ($request->_limit ?? 8);
        $offset = ($page - 1) * $limit;

        $query = Merchandise::query();

        if ($request->_search) {
            $query->where('name', 'like', '%' . $request->_search . '%');
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
     * path="/api/v1/merchandise/{id}",
     * summary="Get a merchandise by ID",
     * tags={"Merchandise"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Merchandise details"
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
     * path="/api/v1/merchandise",
     * summary="Create a new merchandise",
     * tags={"Merchandise"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "description", "price", "image"},
     * @OA\Property(property="name", type="string"),
     * @OA\Property(property="description", type="string"),
     * @OA\Property(property="price", type="number", format="float"),
     * @OA\Property(property="image", type="string", format="binary")
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Merchandise created successfully"
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
     * path="/api/v1/merchandise/{id}",
     * summary="Update a merchandise",
     * tags={"Merchandise"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string"),
     * @OA\Property(property="description", type="string"),
     * @OA\Property(property="price", type="number", format="float")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Merchandise updated successfully"
     * ),
     * @OA\Response(
     * response=404,
     * description="Merchandise not found"
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
     * path="/api/v1/merchandise/{id}",
     * summary="Delete a merchandise",
     * tags={"Merchandise"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Merchandise deleted successfully"
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