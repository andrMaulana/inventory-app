<?php

namespace App\Http\Controllers\Apps;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // get all categories data
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        // get all suppliers data
        $suppliers = Supplier::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.products.create', compact('categories', 'suppliers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       // call trait upload image
       $image = $this->uploadImage($request, $this->path);

       // create product data
       Product::create([
           'name' => $request->name,
           'category_id' => $request->category_id,
           'supplier_id' => $request->supplier_id,
           'description' => $request->description,
           'unit' => $request->unit,
           'image' => $image->hashName(),
       ]);

       // render view
       return to_route('apps.products.index')->with('toast_success', 'Data berhasil ditambahkan');
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
    public function edit(Product $product)
    {
        // get all categories data
        $categories = Category::select('id', 'name')->orderBy('name')->get();

        // get all suppliers data
        $suppliers = Supplier::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.products.edit', compact('categories', 'suppliers', 'product'));
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
