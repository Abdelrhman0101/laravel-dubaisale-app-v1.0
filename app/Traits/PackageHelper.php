<?php

namespace App\Traits;

use App\Models\UserPackage;
use Illuminate\Support\Facades\Log;

trait PackageHelper
{

    public function autoDeductAd($user, string $planType, int $count = 1)
    {
        $package = UserPackage::where('user_id', $user->id)->first();

        if (!$package) {
            return [
                'success' => false,
                'message' => 'User has no active package.',
                'code' => 404
            ];
        }

        if (now()->greaterThan($package->expire_date)) {
            return [
                'success' => false,
                'message' => 'Package expired.',
                'code' => 400
            ];
        }

        $validTypes = ['premium_star', 'premium', 'featured'];
        if (!in_array($planType, $validTypes)) {
            return [
                'success' => false,
                'message' => 'Invalid package type.',
                'code' => 400
            ];
        }

        $total = $package->{$planType . '_ads'};
        $used = $package->{$planType . '_used'};
        $balance = $total - $used;

        if ($balance < $count) {
            return [
                'success' => false,
                'message' => 'No balance left in this package.',
                'code' => 400
            ];
        }

        $package->increment($planType . '_used', $count);

        return [
            'success' => true,
            'message' => "Ad deducted successfully from {$planType} package ✅",
            'package_type' => $planType,
            'remaining_balance' => $balance - $count,
            'expire_date' => $package->expire_date,
        ];
    }
}
