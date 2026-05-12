<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'stats' => [
                'total_users'         => User::where('role', 'client')->count(),
                'total_providers'     => User::where('role', 'provider')->count(),
                'pending_providers'   => User::where('role', 'provider')
                    ->whereHas('providerProfile', fn($q) => $q->where('is_validated', false))
                    ->count(),
                'total_requests'      => ServiceRequest::count(),
                'active_subscriptions'=> Subscription::where('status', 'active')->count(),
                'expired_subscriptions'=> Subscription::where('status', 'expired')->count(),
            ],
        ]);
    }
}