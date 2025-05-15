<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function store(Request $request)
    {
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->selling_price = $request->selling_price;
        $product->buying_price = $request->buying_price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->save();
        return response()->json($product, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product= Product::find($id);
        return response()->json($product,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->selling_price = $request->selling_price;
        $product->buying_price = $request->buying_price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->save();
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product= Product::find($id);
        $product->delete();
        return response()->json(['message'=>'Producto eliminado'], 204);
    }
}
