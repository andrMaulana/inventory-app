<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:users-access', only: ['index']),
            new Middleware('permission:users-update', only: ['update']),
            new Middleware('permission:users-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all user data with paginate
        $users = User::with('roles')->search('name')->latest()->paginate(10);

        // get all role data
        $roles = Role::select('id', 'name')->orderBy('name')->get();

        // render view
        return view('pages.apps.users.index', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // sync role users
        $user->syncRoles($request->roles);

        // render view
        return back()->with('toast_success', 'Data berhasil disimpan.');
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
