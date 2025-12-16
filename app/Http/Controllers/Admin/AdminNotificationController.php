<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;

class AdminNotificationController extends Controller
{
    /**
     * Search users by name or email.
     */
    public function searchUsers(Request $request)
    {
        $term = $request->input('q');
        
        if (empty($term)) {
            return response()->json([]);
        }

        $users = User::where('username', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")
            ->select('id', 'username as name', 'email', 'role as type')
            ->limit(20)
            ->get();

        return response()->json($users);
    }

    /**
     * Send notification to selected users.
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'arabic.title' => 'required|string',
            'arabic.description' => 'required|string',
            'english.title' => 'required|string',
            'english.description' => 'required|string',
            'users' => 'nullable|array',
            'select_all' => 'boolean'
        ]);

        $data = [
            'arabic' => $request->input('arabic'),
            'english' => $request->input('english'),
        ];

        if ($request->boolean('select_all')) {
            // Chunking for performance if sending to all users
            $count = User::count();
            User::chunk(100, function ($users) use ($data) {
                Notification::send($users, new AdminNotification($data));
            });
        } else {
            $usersInput = $request->input('users');
            if (empty($usersInput)) {
                return response()->json(['message' => 'No users selected'], 422);
            }
            
            // Handle if users is array of objects or IDs
            $userIds = [];
            if (is_array($usersInput)) {
                foreach ($usersInput as $user) {
                    if (is_array($user) && isset($user['id'])) {
                        $userIds[] = $user['id'];
                    } elseif (is_numeric($user)) {
                        $userIds[] = $user;
                    }
                }
            }
            
            if (empty($userIds)) {
                 return response()->json(['message' => 'No users selected'], 422);
            }

            $users = User::whereIn('id', $userIds)->get();
            Notification::send($users, new AdminNotification($data));
            $count = $users->count();
        }

        return response()->json(['message' => "Notification sent successfully to {$count} users."]);
    }
}
