<?php

namespace App\Http\Controllers\Apps;

use PDF;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ReportController extends Controller implements HasMiddleware
{
    /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:reports-access', only : ['index', 'filter', 'download']),
        ];
    }

    /**
    * getProductWithStocks
    */
    private function getProductWithStocks($from_date, $to_date, $product)
    {
        $query = Product::with(['stocks' => function($query) use ($from_date, $to_date) {
            $query->whereDate('created_at', '>=', $from_date)
                  ->whereDate('created_at', '<=', $to_date)
                  ->orderBy('created_at');
        }, 'stock' => function($query){
            $query->selectRaw('product_id, created_at, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
                ->groupBy('product_id');
        }]);

        // check when request product is not all
        if ($product !== 'all')
            // get product data by id
            $query->where('id', $product);

        // get product data
        $reports = $query->get();

        return $reports;
    }

}
