<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Http\Request;

class UserPackageController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'premium_star_ads' => 'nullable|integer|min:0',
            'premium_ads' => 'nullable|integer|min:0',
            'featured_ads' => 'nullable|integer|min:0',
            'days' => 'nullable|integer|min:1',
        ]);

        $user = User::find($validated['user_id']);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found ❌',
            ]);
        }

        $package = UserPackage::where('user_id', $user->id)->first();

        $days = $validated['days'] ?? 30;
        $expireDate = now()->addDays($days);

        if ($package) {
            $package->update([
                'premium_star_ads' => $validated['premium_star_ads'] ?? $package->premium_star_ads,
                'premium_ads' => $validated['premium_ads'] ?? $package->premium_ads,
                'featured_ads' => $validated['featured_ads'] ?? $package->featured_ads,
                'days' => $days,
                'expire_date' => $expireDate,
            ]);
        } else {
            $package = UserPackage::create([
                'user_id' => $user->id,
                'premium_star_ads' => $validated['premium_star_ads'] ?? 0,
                'premium_ads' => $validated['premium_ads'] ?? 0,
                'featured_ads' => $validated['featured_ads'] ?? 0,
                'days' => $days,
                'start_date' => now(),
                'expire_date' => $expireDate,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Package assigned/updated successfully ✅',
            'data' => $package,
        ]);
    }


    public function index(Request $request)
    {
        $user = $request->user();
        $type = $request->query('type'); 
        $search = $request->query('q'); 

        
        $query = UserPackage::with('user:id,username,phone');

        
        if ($user->role === 'admin') {

            if ($type && in_array($type, ['premium_star', 'premium', 'featured'])) {
                $query->where("{$type}_ads", '>', value: 0);
            }

            
            if ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }
        }

        else {
            $query->where('user_id', $user->id);
        }

        $packages = $query->get();

        $packages = $packages->map(function ($package) use ($type) {
            $types = ['premium_star', 'premium', 'featured'];
            $details = [];

            if ($type && in_array($type, $types)) {
                $total = $package->{$type . '_ads'};
                $used = $package->{$type . '_used'};
                $balance = max($total - $used, 0);

                $details[$type] = [
                    'total_ads' => $total,
                    'used_ads' => $used,
                    'balance' => $balance,
                    'usage_percent' => $total > 0 ? round(($used / $total) * 100, 2) : 0,
                ];
            } else {
                foreach ($types as $t) {
                    $total = $package->{$t . '_ads'};
                    $used = $package->{$t . '_used'};
                    $balance = max($total - $used, 0);

                    $details[$t] = [
                        'total_ads' => $total,
                        'used_ads' => $used,
                        'balance' => $balance,
                        'usage_percent' => $total > 0 ? round(($used / $total) * 100, 2) : 0,
                    ];
                }
            }

            return [
                'id' => $package->id,
                'user' => [
                    'id' => $package->user->id,
                    'name' => $package->user->name,
                    'phone' => $package->user->phone,
                ],
                'days' => $package->days,
                'expire_date' => $package->expire_date,
                'details' => $details,
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $packages->count(),
            'data' => $packages,
        ]);
    }



    public function destroy($id)
    {
        $package = UserPackage::findOrFail($id);
        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully ❌',
        ]);
    }
}
