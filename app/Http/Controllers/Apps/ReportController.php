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
}
