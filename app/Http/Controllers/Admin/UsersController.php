<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $users = $query->paginate(10);
        $total = User::count();

        return view('admin.users.index', compact('users', 'total'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama user harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Log to user history
        UserHistory::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'create',
            'new_data' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'admin_id' => auth()->id(),
            'created_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
                       ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama user harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        // Prepare old data for history (save before making changes)
        $hasPasswordChange = !empty($validated['password']);
        $oldData = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        $newData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Store plain password in history only (for audit trail)
        if ($hasPasswordChange) {
            $oldData['password'] = '(terenkripsi di database)';
            $newData['password'] = $validated['password'];
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Log to user history only if there are changes
        $hasChanges = false;
        $changedFields = [];
        
        foreach ($newData as $key => $value) {
            if (isset($oldData[$key]) && $oldData[$key] != $value) {
                $hasChanges = true;
                $changedFields[] = $key;
            }
        }

        if ($hasChanges) {
            // Filter to only include changed fields
            $filteredOldData = [];
            $filteredNewData = [];
            
            foreach ($changedFields as $field) {
                $filteredOldData[$field] = $oldData[$field];
                $filteredNewData[$field] = $newData[$field];
            }
            
            UserHistory::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'action' => 'update',
                'old_data' => $filteredOldData,
                'new_data' => $filteredNewData,
                'admin_id' => auth()->id(),
                'created_at' => now(),
            ]);
        }

        return redirect()->route('admin.users.index')
                       ->with('success', 'User berhasil diperbarui');
    }

    /**
     * Delete the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Anda tidak bisa menghapus akun sendiri');
        }

        // Log to user history before deletion
        UserHistory::create([
            'user_id' => $user->id,
            'user_email' => $user->email,
            'action' => 'delete',
            'old_data' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'admin_id' => auth()->id(),
            'created_at' => now(),
        ]);

        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'User berhasil dihapus');
    }
}
