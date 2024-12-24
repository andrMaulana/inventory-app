<?php
namespace App\Http\Controllers\Apps;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class SupplierController extends Controller implements HasMiddleware
{

    /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:suppliers-access', only: ['index']),
            new Middleware('permission:suppliers-create', only: ['create', 'store']),
            new Middleware('permission:suppliers-update', only: ['edit', 'update']),
            new Middleware('permission:suppliers-delete', only: ['destory']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
