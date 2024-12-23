<?php

namespace App\Http\Controllers\Apps;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Traits\HasImage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

     /**
     * call trait HasImage
    */
    use HasImage;


    /**
     * path categories image
     */
    private $path = 'public/categories/';

        /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:categories-access', only : ['index']),
            new Middleware('permission:categories-create', only : ['create', 'store']),
            new Middleware('permission:categories-update', only : ['edit', 'update']),
            new Middleware('permission:categories-delete', only : ['destroy']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all categories data with paginate
        $categories = Category::search('name')->latest()->paginate(10)->withQueryString();

        // render view
        return view('pages.apps.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // render view
        return view('pages.apps.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // call trait upload image
        $image = $this->uploadImage($request, $this->path);

        // create category data
        Category::create([
            'name' => $request->name,
            'image' => $image->hashName(),
        ]);

        // render view
        return to_route('apps.categories.index')->with('toast_success', 'Data berhasil ditambahkan');
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
    public function edit(Category $category)
    {
        // render view
        return view('pages.apps.categories.edit', compact('category'));
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
