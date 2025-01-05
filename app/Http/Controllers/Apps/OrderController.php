<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{

    /**
    * middleware
    */
    public static function middleware()
    {
        return [
            new Middleware('permission:stocks-access', only : ['index']),
            new Middleware('permission:stocks-create', only : ['store']),
        ];
    }

     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // product data
        $products = Product::select('id', 'name')->orderBy('name')->get();

        // check permissions users
        if($request->user()->can('orders-admin')){
            // get all orders data with paginate
            $orders = Order::with(['product' => function($query){
                $query->with(['stock' => function($query){
                    $query->selectRaw('product_id, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
                    ->groupBy('product_id');
                }]);
            }, 'user'])
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }elseif($request->user()->can('orders-users')){
            // get all orders by user id with paginate
            $orders = Order::with('product', 'user')
                ->whereUserId($request->user()->id)
                ->latest()
                ->paginate(10)->withQueryString();
        }

        // render view
        return view('pages.apps.orders.index', compact('orders', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|gt:0'
        ]);

        // create order data
        Order::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => OrderStatus::Pending,
        ]);

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // check permissions users and order status
        if($request->user()->can('orders-users') && $order->status == OrderStatus::Pending){
            // validate request
            $request->validate([
                'product_id' => 'required',
                'quantity' => 'required|integer|gt:0'
            ]);

            // update order data
            $order->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

        // check permissions users and order status
        }elseif($request->user()->can('orders-admin') && $order->status == OrderStatus::Pending){
            // update order data
            $order->update([
                'status' => OrderStatus::Verified,
            ]);

        // check permissions users and order status
        }elseif($request->user()->can('orders-admin') && $order->status == OrderStatus::Verified){
            // create stock data
            $stock = Stock::create([
                'product_id' => $order->product_id,
                'type' => 'in',
                'quantity' => $order->quantity,
            ]);

            // check when stock is true
            if($stock)
                // update order data
                $order->update([
                    'status' => OrderStatus::Success,
                ]);
        }

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // delete order data
        $order->delete();

        // render view
        return back()->with('toast_success', 'Data berhasil dihapus');
    }
}
