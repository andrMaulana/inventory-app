<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    /**
     * Middleware
     */
    public static function middleware()
    {
        return [
            new Middleware('permission:roles-access', only: ['index']),
            new Middleware('permission:roles-create', only: ['create', 'store']),
            new Middleware('permission:roles-update', only: ['edit', 'update']),
            new Middleware('permission:roles-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all role data with paginate
        $roles = Role::when(request()->search, function($search){
            $search = $search->where('name', 'like', '%'. request()->search. '%');
        })->paginate(10);

        // render view
        return view('pages.apps.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all permissions data
        $permissions = Permission::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        // create role data
        $role = Role::create(['name' => $request->name]);

        // attach permissions to role
        $role->givePermissionTo($request->permissions);

        // render view
        return to_route('apps.roles.index')->with('toast_success', 'Data berhasil ditambahkan');
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
    public function edit(Role $role)
    {
        // get all permissions data
        $permissions = Permission::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.roles.edit', compact('role', 'permissions'));
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
