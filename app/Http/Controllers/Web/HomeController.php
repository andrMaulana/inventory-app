<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
      // get all products data with pagination
    $products = Product::with(['category', 'supplier', 'stock' => function($query){
        $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
        ->groupBy('product_id');
    }])->search('name')->latest()->paginate(9)->withQueryString();

    // get all categories data with pagination
    $categories = Category::withCount('products')
        ->latest()
        ->paginate(9)->withQueryString();

    return view('web.home', compact('products', 'categories'));
    }
}
