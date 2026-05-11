<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // POST /api/v1/client/reviews
    public function store(Request $request)
    {
        $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'rating'             => 'required|integer|min:1|max:5',
            'comment'            => 'nullable|string|max:500',
        ]);

        $serviceRequest = ServiceRequest::where('id', $request->service_request_id)
            ->where('client_id', $request->user()->id)
            ->where('status', 'completed')
            ->firstOrFail();

        // Vérifier qu'un avis n'existe pas déjà
        if (Review::where('service_request_id', $serviceRequest->id)->exists()) {
            return response()->json(['message' => 'Vous avez déjà laissé un avis'], 422);
        }

        $review = Review::create([
            'service_request_id' => $serviceRequest->id,
            'client_id'          => $request->user()->id,
            'provider_id'        => $serviceRequest->provider_id,
            'rating'             => $request->rating,
            'comment'            => $request->comment,
        ]);

        // Recalculer la note moyenne du prestataire
        $profile = ProviderProfile::where('user_id', $serviceRequest->provider_id)->first();
        if ($profile) {
            $avg = Review::where('provider_id', $serviceRequest->provider_id)->avg('rating');
            $count = Review::where('provider_id', $serviceRequest->provider_id)->count();
            $profile->update([
                'average_rating' => round($avg, 2),
                'reviews_count'  => $count,
            ]);
        }

        return response()->json([
            'message' => 'Avis envoyé avec succès',
            'review'  => $review,
        ], 201);
    }
}