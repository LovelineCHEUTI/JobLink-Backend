<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProviderProfile;

class ProviderController extends Controller
{
    // GET /api/v1/admin/providers
    public function index()
    {
        $providers = User::where('role', 'provider')
            ->with(['providerProfile', 'subscriptions' => fn($q) => $q->latest()])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($providers);
    }

    // GET /api/v1/admin/providers/pending
    public function pending()
    {
        $providers = User::where('role', 'provider')
            ->whereHas('providerProfile', fn($q) => $q->where('is_validated', false))
            ->with('providerProfile')
            ->get();

        return response()->json($providers);
    }

    // PUT /api/v1/admin/providers/{id}/validate
    public function validate($id)
    {
        $profile = ProviderProfile::where('user_id', $id)->firstOrFail();
        $profile->update(['is_validated' => true]);

        return response()->json(['message' => 'Prestataire validé']);
    }

    // PUT /api/v1/admin/providers/{id}/toggle
    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'message'   => $user->is_active ? 'Compte activé' : 'Compte bloqué',
            'is_active' => $user->is_active,
        ]);
    }
}