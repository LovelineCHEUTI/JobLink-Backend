<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // GET /api/v1/admin/subscriptions
    public function index()
    {
        $subscriptions = Subscription::with('user:id,name,email,city')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($subscriptions);
    }

    // POST /api/v1/admin/subscriptions
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type'    => 'required|in:monthly,quarterly,annual',
        ]);

        $days = match($request->type) {
            'monthly'   => 30,
            'quarterly' => 90,
            'annual'    => 365,
        };

        $subscription = Subscription::create([
            'user_id'    => $request->user_id,
            'type'       => $request->type,
            'status'     => 'active',
            'starts_at'  => now(),
            'expires_at' => now()->addDays($days),
        ]);

        return response()->json([
            'message'      => 'Abonnement créé',
            'subscription' => $subscription,
        ], 201);
    }

    // PUT /api/v1/admin/subscriptions/{id}/renew
    public function renew($id)
    {
        $subscription = Subscription::findOrFail($id);

        $days = match($subscription->type) {
            'monthly'   => 30,
            'quarterly' => 90,
            'annual'    => 365,
            default     => 30,
        };

        $subscription->update([
            'status'     => 'active',
            'starts_at'  => now(),
            'expires_at' => now()->addDays($days),
        ]);

        return response()->json([
            'message'      => 'Abonnement renouvelé',
            'subscription' => $subscription,
        ]);
    }

    // PUT /api/v1/admin/subscriptions/{id}/block
    public function block($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'blocked']);

        return response()->json(['message' => 'Abonnement bloqué']);
    }
}