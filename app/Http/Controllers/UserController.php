<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('finetech.users.index', ['users' => $users]);
    }
    public function create()
    {
        $roles = Role::all();
        return view('finetech.users.create', ['roles' => $roles]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);
                $user->assignRole($request->role);
            });
            toastr()->success('User created successfully');
            return redirect()->route('finetech.users.index');

        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }
    public function show(User $user)
    {
        return view('finetech.users.show', ['user' => $user]);
    }
    public function edit(User $user)
    {
        return view('finetech.users.edit', [
            "user" => $user,
            "roles" => Role::all(),
            "userRole" => $user->roles->pluck('name')->first()
        ]);
    }
    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                if ($request->filled('password')) {
                    $user->update(['password' => bcrypt($request->password)]);
                }

                $user->syncRoles([$request->role]);
            });

            toastr()->success('User updated successfully');
            return redirect()->route('finetech.users.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function destroy(User $user)
    {
        try {
            $user->delete();
            toastr()->success("User deleted successfully.");
            return redirect()->route("finetech.users.index");
        } catch (\Exception $e) {
            toastr()->error("Failed to delete user. Please try again.");
            return redirect()->back();
        }
    }
    public function toggleStatus(User $user)
    {
        try {
            $user->update(['status' => !$user->status]);
            $state = $user->status ? 'activated' : 'deactivated';
            toastr()->success("User {$state} successfully.");
        } catch (\Exception $e) {
            toastr()->error('Failed to update user status. Please try again.');
        }

        return redirect()->back();
    }
}
