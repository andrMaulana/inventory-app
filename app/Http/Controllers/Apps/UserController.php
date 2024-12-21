<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller
{

    public static function middleware()
    {
        return [
            new Middleware('permission:users-access', only: ['index']),
            new Middleware('permission:users-update', only: ['update']),
            new Middleware('permission:user-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all user data with paginate
        $users = User::with('roles')->search('name')->latest()->paginate(10);

        // get all roles data
        $roles = Role::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.users.index', compact('users', 'roles'));
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
    public function update(Request $request, User $user)
    {
        // sync role users
        $user->syncRoles($request->roles);

        // render view
        return back()->with('toast_success', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // delete user data
        $user->delete();

        // render view
        return back()->with('toast_success', 'Data berhasil dihapus.');
    }
}
