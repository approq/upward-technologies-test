<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return Renderable
     */
    public function edit(Product $product)
    {
        if (Auth::user()->id !== $product->user_id) {
            return abort(404);
        }
        return view('products.edit', ['product_id' => $product->id]);
    }
}
