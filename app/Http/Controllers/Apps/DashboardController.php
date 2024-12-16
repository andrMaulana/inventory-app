<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends Controller implements HasMiddleware
{
     /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:dashboard-access'),
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // count categories data
        $categories = Category::count();

        // count suppliers data
        $suppliers = Supplier::count();

        // count products data
        $products = Product::count();

        // count customers data
        $customers = User::with('roles')->get()->filter(fn($user) => $user->roles->where('name', 'customer')->toArray())->count();

        // count total transaction
        $transactions = TransactionDetail::sum('quantity');

        // count total transaction on this month
        $transactionThisMonth = TransactionDetail::whereMonth('created_at', date('m'))->sum('quantity');

        // count product out stock data
        $productsOutStock = Product::with(['stock' => function($query){
            $query->selectRaw(
                    'product_id,
                    SUM(
                        CASE
                            WHEN
                                type = "in" THEN quantity
                            WHEN
                                type = "out" THEN -quantity
                            ELSE
                                0 END
                    ) as total_quantity')
                ->groupBy('product_id');
            }])
            ->whereHas('stock', function($query){
                $query->havingRaw('SUM(CASE WHEN type = "in" THEN quantity WHEN type = "out" THEN -quantity ELSE 0 END) <= 10');
            })->paginate(10);

        // count best products data
        $bestProduct = TransactionDetail::query()
            ->selectRaw('products.name, sum(transaction_details.quantity) as total')
            ->join('products', 'products.id', '=', 'transaction_details.product_id')
            ->groupBy('transaction_details.product_id')
            ->orderBy('total', 'DESC')
            ->limit(5)
            ->get();

        // $bestProduct = TransactionDetail::select('products.name')
        // ->join('products', 'products.id', '=', 'transaction_details.product_id')
        // ->groupBy('products.name', 'transaction_details.product_id')
        // ->selectRaw('SUM(transaction_details.quantity) as total')
        // ->orderBy('total', 'DESC')
        // ->limit(5)
        // ->get();

        $label = [];
        $total = [];

        if(count($bestProduct)){
            foreach($bestProduct as $data){
                array_push($label, $data->name);
                array_push($total, (int) $data->total);
            }
        }

        // check permissions users
        if($request->user()->can('dashboard-admin')){
            // count all orders data
            $orders = Order::count();

            // count all transactions data
            $transactions = Transaction::count();
        }else{
            // count all orders data by userId
            $orders = Order::whereUserId($request->user()->id)->count();

            // count all transactions data by userId
            $transactions = Transaction::whereUserId($request->user()->id)->count();
        }

        // render view
        return view('apps.dashboard', compact('categories','suppliers', 'products', 'customers', 'transactions', 'transactionThisMonth', 'productsOutStock', 'bestProduct', 'total', 'label', 'orders', 'transactions'));
    }
}
