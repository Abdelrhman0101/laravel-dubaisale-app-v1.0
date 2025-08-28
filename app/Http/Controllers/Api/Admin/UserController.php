<?php

// ========= السطر الأكثر أهمية هو هذا السطر =========
namespace App\Http\Controllers\Api\Admin;
// ===============================================

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * [Admin] Display a listing of all users.
     */
    public function index()
    {
        return User::latest()->paginate(20);
    }

    /**
     * [Admin] Store a newly created user.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        if (!isset($validatedData['email']) && !isset($validatedData['phone'])) {
            return response()->json(['message' => 'Email or phone field is required.'], 422);
        }
        
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['is_active'] = true;

        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    /**
     * [Admin] Display the specified user.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * [Admin] Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['sometimes', 'string', Rule::in(['admin', 'user'])],
            // Add other updatable fields here
        ]);

        $user->update($data);
        return response()->json($user);
    }

    /**
     * [Admin] Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}