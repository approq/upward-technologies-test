<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $products = Auth::user()->products;

        return response()->json(['items' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductStoreRequest  $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request)
    {
        $user = Auth::user();

        $data = $request->only('name', 'manufactured');

        $file = $request->file('photo');

        $path = '/photos';

        $fullPath = $file->store($path, 'public');

        $data['photo'] = '/storage/'.$fullPath;

        $user->products()->create($data);

        return response()->json(['message' => 'created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        $user = Auth::user();

        if ($product->user_id !== $user->id) {
            return response()->json(['error' => "Couldn't fount product to update"], 403);
        }

        return response()->json(['item' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductUpdateRequest  $request
     * @param  Product  $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $user = Auth::user();

        if ($product->user_id !== $user->id) {
            return response()->json(['error' => "Couldn't fount product to update"], 403);
        }

        $data = $request->only('name', 'manufactured');

        $file = $request->file('photo');

        if ($file) {
            $path = '/photos';

            $fullPath = $file->store($path, 'public');

            $data['photo'] = $fullPath;

            Storage::delete($product->photo);
        }

        $product->update($data);

        return response()->json(['message' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'deleted']);
    }
}
