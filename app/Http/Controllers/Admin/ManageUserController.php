<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManageUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')->latest();

        // Apply filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->paginate(10);

        return view('admin.manage_users', compact('users'));
    }

    public function create()
    {
        return view('admin.create_user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'email_verified_at' => now(), // Auto-verify admin-created users
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function show(User $user)
    {
        $user->load(['orders' => function($query) {
            $query->latest()->take(5);
        }, 'addresses']);

        return view('admin.user_details', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $updateData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $user->update($updateData);

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            // Check if user has orders
            if ($user->orders()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete user with existing orders. Please delete orders first.');
            }

            $user->addresses()->delete();
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }

    public function toggleVerification(User $user)
    {
        try {
            if ($user->email_verified_at) {
                $user->update(['email_verified_at' => null]);
                $message = 'User email verification removed.';
            } else {
                $user->update(['email_verified_at' => now()]);
                $message = 'User email verified successfully.';
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating verification status: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:verify,unverify,delete'
        ]);

        $userIds = $request->user_ids;
        $action = $request->action;

        try {
            foreach ($userIds as $userId) {
                $user = User::find($userId);

                switch ($action) {
                    case 'verify':
                        $user->update(['email_verified_at' => now()]);
                        break;

                    case 'unverify':
                        $user->update(['email_verified_at' => null]);
                        break;

                    case 'delete':
                        if ($user->orders()->count() === 0) {
                            $user->addresses()->delete();
                            $user->delete();
                        }
                        break;
                }
            }

            $message = match($action) {
                'verify' => 'Selected users verified successfully.',
                'unverify' => 'Selected users unverified successfully.',
                'delete' => 'Selected users deleted successfully.',
            };

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }
}