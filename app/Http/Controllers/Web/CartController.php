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
        return view('web.carts.index', compact('carts', 'grandQuantity'));
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

    public function update(Request $request, Cart $cart)
    {
        // get product data by id
        $product = Product::with(['category', 'supplier', 'stock' => function($query){
            $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
            ->groupBy('product_id');
        }])->whereId($cart->product_id)->first();

        if($product->stock->stock < $request->quantity){
            // render view
            return back()->with('toast_error', 'Stok produk tidak mencukupi');
        }elseif($request->quantity <= 0){
            // render view
            return back()->with('toast_error', 'Mohon masukan jumlah yg valid');
        }else{
            // update cart quantity
            $cart->update([
                'quantity' => $request->quantity,
            ]);

            // render view
            return back()->with('toast_success', 'Jumlah produk berhasil diubah');
        }
    }

    public function destroy(Cart $cart)
    {
        // delete cart data
        $cart->delete();

        // render view
        return back()->with('toast_success', 'Produk berhasil dikeluarkan dari keranjang');
    }
}
