<?php

namespace App\Http\Controllers\Apps;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TransactionController extends Controller implements HasMiddleware
{

    /**
     * middleware
    */
    public static function middleware()
    {
        return [
            new Middleware('permission:transactions-access'),
        ];
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // check permission users
        if ($request->user()->can('transactions-admin')) {
            // get all transaction data with paginate
            $transactions = Transaction::with(['details' => function($query) {
                $query->sum('quantity');
            }])
            ->search('invoice')
            ->latest()
            ->paginate(10)
            ->withQueryString();
        }elseif($request->user()->can('transactions-users')){
            // get all transaction by user with paginate
            $transactions = Transaction::with('details')
                ->whereUserId($request->user()->id())
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        // add new column in collection transactions total_quantity
        $transactions->getCollection()->transform(function($transaction){
            $transaction->total_quantity = $transaction->details->sum('quantity');
            return $transaction;
        });

        // render view
        return view('pages.apps.transaction', compact('transactions'));
    }
}
