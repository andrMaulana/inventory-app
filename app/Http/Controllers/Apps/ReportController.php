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

    /**
    * getFirstStock
    */
    private function getFirstStock($from_date)
    {
        $get_first_stocks = Product::with(['stock' => function($query) use($from_date){
            $query->selectRaw('product_id, created_at, SUM(CASE WHEN type = "in" THEN quantity ELSE quantity*-1 END) as stock')
                ->whereDate('created_at', '<', $from_date)
                ->groupBy('product_id');
        }])->get();

        // first stock
        $first_stock = [];

        // loop first stock product data
        foreach($get_first_stocks as $item){
            // check if stock is not null
            if($item->stock != null)
                // assign first stock with stock
                $first_stock[$item->id] = [
                    'stok' => $item->stock->stock,
                    'date' => $item->stock->created_at->format('Y-m-d'),
                ];
        }

        return $first_stock;
    }

    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        // get first date stock
        $min_date_stock = Stock::select('created_at')->orderBy('created_at', 'asc')->first();

        // format first date stock
        $min_date = $min_date_stock ? $min_date_stock->created_at->format('Y-m-d') : Carbon::today()->format('Y-m-d');

        // max date is today
        $max_date = Carbon::today()->format('Y-m-d');

        // request from_date
        $from_date = $request->from_date;

        // request to_date
        $to_date = $request->to_date;

        // get all products data
        $products = Product::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.reports.index', compact('min_date', 'max_date', 'products', 'from_date', 'to_date'));
    }
}
