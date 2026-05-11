<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    // GET /api/v1/providers
    public function index(Request $request)
    {
        $query = User::where('role', 'provider')
            ->where('is_active', true)
            ->whereHas('providerProfile', fn($q) => $q->where('is_validated', true))
            ->whereHas('subscriptions', fn($q) => $q->where('status', 'active'))
            ->with(['providerProfile', 'categories']);

        if ($request->search) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        if ($request->city) {
            $query->where('city', 'ilike', '%' . $request->city . '%');
        }

        if ($request->category_id) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $request->category_id));
        }

        $providers = $query->paginate(10);

        return response()->json($providers);
    }

    // GET /api/v1/providers/{id}
    public function show($id)
    {
        $provider = User::where('role', 'provider')
            ->where('id', $id)
            ->with(['providerProfile', 'services.category', 'categories'])
            ->firstOrFail();

        return response()->json($provider);
    }
}