<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $sale = new Sale();
        $sale->product_id = $request->product_id;
        $sale->name = $request->name;
        $sale->quantity = $request->quantity;
        $sale->price = $request->price;
        $sale->taxes = $request->taxes;
        $sale->total = $request->total;
        $sale->save();
        return response()->json($sale, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product= Sale::find($id);
        return response()->json($product,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sale = Sale::find($id);
        $sale->product_id = $request->product_id;
        $sale->name = $request->name;
        $sale->quantity = $request->quantity;
        $sale->price = $request->price;
        $sale->taxes = $request->taxes;
        $sale->total = $request->total;
        $sale->save();
        return response()->json($sale, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product= Sale::find($id);
        $product->delete();
        return response()->json(['message'=>'Venta eliminada'], 204);
    }
}
