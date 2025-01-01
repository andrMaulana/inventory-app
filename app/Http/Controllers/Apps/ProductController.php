<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Traits\HasImage;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class ProductController extends Controller implements HasMiddleware
{

    /**
     * call trait HasImage
    */
    use HasImage;

    /**
     * path productss image
     */
    private $path = 'public/products/';

    /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:products-access', only : ['index']),
            new Middleware('permission:products-create', only : ['create', 'store']),
            new Middleware('permission:products-update', only : ['edit', 'update']),
            new Middleware('permission:products-delete', only : ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      // get all products data with paginate
      $products = Product::with('category', 'supplier')->search('name')->latest()->paginate(10)->withQueryString();

      // render view
      return view('pages.apps.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
