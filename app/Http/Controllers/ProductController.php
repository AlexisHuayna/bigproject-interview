<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
                'success' => true,
                'data' => $products
            ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required|numeric|gte:0'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $product = Product::create($input);

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json(['success' => false, "message" => 'product not found'], 422);
        }

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $input = $request->all();

        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json(['success' => false, "message" => 'product not found'], 422);
        }

        $product->name = $input['name'] ?? $product->name;
        $product->description = $input['description'] ?? $product->description;
        $product->price = $input['price'] ?? $product->price;
        $product->save();

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json(['success' => false, "message" => 'product not found'], 422);
        }

        $product->delete();

        return response()->json([
            "success" => true,
            "data" => $product
        ]);
    }
}
