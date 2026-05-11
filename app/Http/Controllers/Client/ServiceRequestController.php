<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    // POST /api/v1/client/requests
    public function store(Request $request)
    {
        $request->validate([
            'provider_id'  => 'required|exists:users,id',
            'title'        => 'required|string|min:5',
            'description'  => 'required|string|min:10',
            'location'     => 'required|string',
            'desired_date' => 'nullable|date',
        ]);

        $provider = User::where('id', $request->provider_id)
            ->where('role', 'provider')
            ->where('is_active', true)
            ->firstOrFail();

        $serviceRequest = ServiceRequest::create([
            'client_id'    => $request->user()->id,
            'provider_id'  => $request->provider_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'location'     => $request->location,
            'desired_date' => $request->desired_date,
            'status'       => 'pending',
        ]);

        return response()->json([
            'message' => 'Demande envoyée avec succès',
            'request' => $serviceRequest,
        ], 201);
    }

    // GET /api/v1/client/requests
    public function index(Request $request)
    {
        $requests = ServiceRequest::where('client_id', $request->user()->id)
            ->with(['provider:id,name,city,phone', 'provider.providerProfile'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($requests);
    }

    // DELETE /api/v1/client/requests/{id}
    public function destroy(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::where('id', $id)
            ->where('client_id', $request->user()->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $serviceRequest->delete();

        return response()->json(['message' => 'Demande annulée']);
    }
}