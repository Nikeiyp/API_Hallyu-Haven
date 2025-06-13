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
 *     ),
 * )
 */

class MerchandiseController extends Controller
{

/**
 * @OA\Get(
 *     path="/api/merchandise",
 *     summary="merchandise list",
 *     tags={"merchandise"},
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     )
 * )
 */
    public function index() {
        return Merchandise::all();
    }

    /**
 * @OA\Post(
 *     path="/api/merchandise",
 *     summary="Tambah merchandise baru",
 *     tags={"merchandise"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price"},
 *             @OA\Property(property="name", type="string", example="Lightstick EXO"),
 *             @OA\Property(property="description", type="string", example="Official EXO Lightstick"),
 *             @OA\Property(property="price", type="number", format="float", example=450000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Berhasil menambahkan merchandise"
 *     )
 * )
 */

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|string'
        ]);

        return Merchandise::create($data);
    }

    /**
 * @OA\Get(
 *     path="/api/merchandise/{id}",
 *     summary="Ambil satu merchandise berdasarkan ID",
 *     tags={"merchandise"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data merchandise ditemukan"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Data tidak ditemukan"
 *     )
 * )
 */

    public function show($id) {
        return Merchandise::findOrFail($id);
    }

    /**
 * @OA\Put(
 *     path="/api/merchandise/{id}",
 *     summary="Update data merchandise",
 *     tags={"merchandise"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Lightstick Blackpink"),
 *             @OA\Property(property="description", type="string", example="Limited Edition"),
 *             @OA\Property(property="price", type="number", format="float", example=399000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Data merchandise berhasil diupdate"
 *     )
 * )
 */

    public function update(Request $request, $id) {
        $merch = Merchandise::findOrFail($id);
        $merch->update($request->all());
        return $merch;
    }

    /**
 * @OA\Delete(
 *     path="/api/merchandise/{id}",
 *     summary="Hapus merchandise",
 *     tags={"merchandise"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Berhasil dihapus"
 *     )
 * )
 */

    public function destroy($id) {
        Merchandise::destroy($id);
        return response()->json(null, 204);
    }
}
