<?php

// ========= السطر الأكثر أهمية هو هذا السطر =========
namespace App\Http\Controllers\Api\Admin;
// ===============================================

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * [Admin] Display a listing of all users.
     */
    public function index()
    {
        return User::with('bestAdvertiser') // load 
            ->latest()
            ->paginate(20);
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
        if (isset($validatedData['otp_verified'])) {
            return response()->json(['message' => 'Access denied.']);
        }

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
        $user->load('bestAdvertiser');
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
        if (isset($data['otp_verified'])) {
            return response()->json(['message' => 'Access denied.']);
        }
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

    // public function convertToAdvertiser(User $user, $id)
    // {
    //     $user = User::findOrFail($id);
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found.'], 404);
    //     }
    //     if ($user->user_type == 'advertiser') {
    //         return response()->json(['message' => 'User is already an advertiser.'], 400);
    //     }
    //     if (Cache::has("otp_limit:$user->phone")) {
    //         return response()->json([
    //             'message' => 'Please wait before requesting another OTP.'
    //         ], 429);
    //     }
    //     $otp = '3457';
    //     $otpHash = Hash::make($otp);
    //     $otpExpiresAt = Carbon::now()->addMinutes(10);
    //     // $user->user_type = 'advertiser';
    //     $user->otp_phone = $otpHash;
    //     $user->otp_expires_at = $otpExpiresAt;
    //     $user->otp_verified = false;
    //     $user->save();
    //     Cache::put("otp_limit:$user->phone", true, 60);

    //     return response()->json($user);
    // }


    public function changePass(Request $request)
    {
        $data = $request->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        if (!Hash::check($data['currentPassword'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->update([
            'password' => Hash::make($data['newPassword']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Password changed successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function setAddress(Request $request, User $user)
    {
        $data = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180', 
        ]);

        $user->update($data);
        return response()->json($user->fresh());
    }
}
