<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class StockController extends Controller implements HasMiddleware
{
    /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:stocks-access', only : ['index']),
            new Middleware('permission:stocks-create', only : ['store'])
        ];
    }

    /**
    *  Display a listing of the resource
    */

    public function index()
    {
        // get all products data with paginate
        $products = Product::with(['category', 'stocks', 'stock' => function($query){
            $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')->groupBy('product_id');
        }])->search('name')->latest()->paginate(10)->withQueryString();

        // render view
        return view('pages.apps.stocks.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function strore(Product $product, Request $request)
    {
        // validate request
        $request->validate([
            'quantity' => 'required|integer|gt:0'
        ]);

        // created new stock
        $product->stock()->create([
            'type' => 'in',
            'quantity' => $request->quantity
        ]);

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan');
    }
}
