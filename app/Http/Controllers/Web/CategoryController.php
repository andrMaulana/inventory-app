<?php

namespace App\Http\Controllers\Web;

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

    }
}
