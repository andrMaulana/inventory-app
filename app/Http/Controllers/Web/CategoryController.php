<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        // get all category data
        $categories = Category::withCount('products')
            ->latest()
            ->search('name')
            ->get();

        // render view
        return view('web.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        // get produts by category data
        $products = Product::with(['category', 'supplier', 'stock' => function($query){
            $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
                ->groupBy('product_id');
            }])
            ->where('category_id', $category->id)
            ->latest()
            ->search('name')
            ->get();

        // render view
        return view('web.categories.show', compact('products', 'category'));
    }
}
