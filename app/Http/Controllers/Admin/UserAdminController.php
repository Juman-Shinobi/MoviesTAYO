<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim();
        $role = $request->string('role')->trim();

        $users = User::query()
            ->when($search->isNotEmpty(), function ($query) use ($search) {
                $value = $search->toString();
                $query->where('name', 'like', "%{$value}%");
            })
            ->when($role->isNotEmpty(), function ($query) use ($role) {
                $query->where('role', $role->toString());
            })
            ->orderBy('name')
            ->get();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,employee'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'account_created',
            'description' => 'Created '.$user->role.' account for '.$user->email,
            'metadata' => ['user_id' => $user->id],
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Account created.');
    }
}
