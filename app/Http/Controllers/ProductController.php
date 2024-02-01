<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    public function index():JsonResponse
    {
        $product = Product::all();
        return response()->json(['products'=>$product, 'message'=>'butun Productlar getirildi'],200);
    }

    public function store(ProductCreateRequest $request)
    {


        $product = Product::create(array_merge($request->all(), ['user_id' => auth()->id()]));
        return response()->json([
            'message' => 'product created successfully',
            'product'=>$product,
        ]);
    }

    public function show(Product $product):JsonResponse
    {
        return response()->json([
            'product' => $product,
            'api_token' => $product->api_token,
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product):JsonResponse
    {
        if (auth()->id()!=$product->user_id){
            return response()->json([
                'product' => $product,
                'message' => 'not permission',
            ]);
        }

        $product->update($request->all());

        return response()->json([
            'product' => $product,
            'message' => 'product updated successfully',
        ]);
    }

    public function destroy(Product $product):JsonResponse
    {
        if (auth()->id()!=$product->user_id){
            return response()->json([
                'product' => $product,
                'message' => 'not permission',
            ]);
        }
        $product->delete();

        return response()->json([
            'product' => $product,
            'message' => 'product deleted successfully',
        ]);
    }
}
