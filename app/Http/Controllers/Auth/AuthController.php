<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // POST /api/v1/auth/register
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'phone'     => $request->phone ?? null,
            'city'      => $request->city ?? null,
            'is_active' => true,
        ]);

        if ($user->role === 'provider') {
            ProviderProfile::create([
                'user_id'      => $user->id,
                'is_validated' => false,
            ]);
        }

        $token = $user->createToken('joblink-token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription réussie',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    // POST /api/v1/auth/login
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'Compte désactivé'
            ], 401);
        }

        $token = $user->createToken('joblink-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ]);
    }

    // POST /api/v1/auth/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    // GET /api/v1/auth/me
    public function me(Request $request)
    {
        return response()->json(
            $request->user()->load('providerProfile')
        );
    }

    // POST /api/v1/auth/refresh
    public function refresh(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token = $request->user()->createToken('joblink-token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }
}