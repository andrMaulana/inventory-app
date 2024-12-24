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
        // get all suppliers data with paginate
        $suppliers = Supplier::search('name')->latest()->paginate(10)->withQueryString();

        // render view
        return view('pages.apps.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // render view
        return view('pages.apps.suppliers.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        // create supplier data
        Supplier::create([
            'name' => $request->name,
            'telp' => $request->telp,
            'address' => $request->address,
        ]);

        // render view
        return to_route('apps.suppliers.index')->with('toast_success', 'Data berhasil ditambahkan');
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
