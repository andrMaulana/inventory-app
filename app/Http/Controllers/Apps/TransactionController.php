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
        //
    }
}
