<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{

    /**
     * middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:permissions-access', only: ['index']),
            new Middleware('permission:permissions-create', only: ['store']),
            new Middleware('permission:permissions-update', only: ['update']),
            new Middleware('permission:permissions-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all permissions data with paginate
        $permissions = Permission::when(request()->search, function($search){
            $search = $search->where('name', 'like', '%'. request()->search. '%');
        })->latest()->paginate(10);

        // render view
        return view('pages.apps.permissions.index', compact('permissions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:permissions',
        ]);

        // create permissions data
        Permission::create(['name' => $request->name]);

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        // validate request
        $request->validate([
            'name' => 'required','unique:permissions,name'. $permission,
        ]);

        // update permission data
        $permission->update(['name' => $request->name]);

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        // delete permission
        $permission->delete();

        // render view
        return back()->with('toast_success', 'Data berhasil dihapus');
    }
}
