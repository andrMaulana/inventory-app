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

    public function store(Request $request, Product $product)
    {
        // get item if already in cart
        $alreadyInCart = Cart::with('product')
            ->whereUserId($request->user()->id)
            ->whereProductId($product->id)
            ->first();

        if($alreadyInCart){
            // render view
            return back()->with('toast_error', 'Produk sudah ada didalam keranjang');
        }else{
            // create new cart data
            $request->user()->carts()->create([
                'product_id' => $product->id,
                'quantity' => '1',
            ]);

            // render view
            return redirect(route('cart.index'))->with('toast_success', 'Produk berhasil ditambahkan keranjang');
        }
    }
}
