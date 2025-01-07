<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // get all carts data
        $carts = Cart::with('product')
            ->latest()
            ->whereUserId($request->user()->id)
            ->get();

        // sum total quantity data
        $grandQuantity = $carts->sum('quantity');

        // render view
        return view('pages.web.carts.index', compact('carts', 'grandQuantity'));
    }
}
