<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        // get products data with stock
        $products = Product::with(['supplier', 'category', 'stock' => function($query){
            $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
                ->groupBy('product_id');
            }])->search('name')
            ->latest()
            ->get();

        // render view
        return view('web.products.index',compact('products'));
    }

    public function show(Product $product)
    {
        // get product data with stock
        $product->load(['category', 'supplier', 'stock' => function($query){
            $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
            ->groupBy('product_id');
        }]);

        // render view
        return view('web.products.show', compact('product'));
    }
}
