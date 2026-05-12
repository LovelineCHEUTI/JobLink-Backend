<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // PUT /api/v1/provider/profile
    public function update(Request $request)
    {
        $request->validate([
            'name'        => 'sometimes|string|max:100',
            'phone'       => 'sometimes|string|max:20',
            'city'        => 'sometimes|string|max:100',
            'description' => 'sometimes|string',
        ]);

        // Mettre à jour les infos utilisateur
        $request->user()->update(
            $request->only('name', 'phone', 'city')
        );

        // Mettre à jour le profil prestataire
        ProviderProfile::where('user_id', $request->user()->id)
            ->update(['description' => $request->description]);

        return response()->json([
            'message' => 'Profil mis à jour',
            'user'    => $request->user()->load('providerProfile'),
        ]);
    }

    // GET /api/v1/provider/subscription
    public function subscription(Request $request)
    {
        $subscription = $request->user()
            ->subscriptions()
            ->latest()
            ->first();

        return response()->json($subscription);
    }
}