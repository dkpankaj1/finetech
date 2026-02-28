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
            'aadhar_number' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'aadhar_number' => $request->aadhar_number ?? null,
                    'phone_number' => $request->phone_number ?? null,
                    'address' => $request->address ?? null,
                    'city' => $request->city ?? null,
                    'state' => $request->state ?? null,
                    'postal_code' => $request->postal_code ?? null,
                    'country' => $request->country ?? null,
                    'is_active' => $request->is_active ?? 0,
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
            'aadhar_number' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'aadhar_number' => $request->aadhar_number ?? $user->aadhar_number,
                    'phone_number' => $request->phone_number ?? $user->phone_number,
                    'address' => $request->address ?? $user->address,
                    'city' => $request->city ?? $user->city,
                    'state' => $request->state ?? $user->state,
                    'postal_code' => $request->postal_code ?? $user->postal_code,
                    'country' => $request->country ?? $user->country,
                    'is_active' => $request->is_active ?? $user->is_active,
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
