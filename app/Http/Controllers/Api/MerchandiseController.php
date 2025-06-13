<?php

namespace App\Http\Controllers\Api;

use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index() {
        return Merchandise::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|string'
        ]);

        return Merchandise::create($data);
    }

    public function show($id) {
        return Merchandise::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $merch = Merchandise::findOrFail($id);
        $merch->update($request->all());
        return $merch;
    }

    public function destroy($id) {
        Merchandise::destroy($id);
        return response()->json(null, 204);
    }
}
