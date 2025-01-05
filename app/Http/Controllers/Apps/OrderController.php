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

class OrderController extends Controller
{
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
}
