<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $providerId = $request->user()->id;

        $pending   = ServiceRequest::where('provider_id', $providerId)->where('status', 'pending')->count();
        $accepted  = ServiceRequest::where('provider_id', $providerId)->where('status', 'accepted')->count();
        $completed = ServiceRequest::where('provider_id', $providerId)->where('status', 'completed')->count();
        $total     = ServiceRequest::where('provider_id', $providerId)->count();

        $recentRequests = ServiceRequest::where('provider_id', $providerId)
            ->with(['client:id,name,city,phone'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $profile = $request->user()->load('providerProfile');

        return response()->json([
            'stats' => [
                'pending'   => $pending,
                'accepted'  => $accepted,
                'completed' => $completed,
                'total'     => $total,
            ],
            'recent_requests' => $recentRequests,
            'profile'         => $profile,
        ]);
    }
}