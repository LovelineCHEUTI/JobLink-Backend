<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //
}
<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    // GET /api/v1/provider/requests
    public function index(Request $request)
    {
        $requests = ServiceRequest::where('provider_id', $request->user()->id)
            ->with(['client:id,name,city,phone'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($requests);
    }

    // PUT /api/v1/provider/requests/{id}/accept
    public function accept(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::where('id', $id)
            ->where('provider_id', $request->user()->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $serviceRequest->update(['status' => 'accepted']);

        return response()->json(['message' => 'Demande acceptée']);
    }

    // PUT /api/v1/provider/requests/{id}/reject
    public function reject(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::where('id', $id)
            ->where('provider_id', $request->user()->id)
            ->where('status', 'pending')
            ->firstOrFail();

        $serviceRequest->update(['status' => 'rejected']);

        return response()->json(['message' => 'Demande refusée']);
    }

    // PUT /api/v1/provider/requests/{id}/complete
    public function complete(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::where('id', $id)
            ->where('provider_id', $request->user()->id)
            ->where('status', 'accepted')
            ->firstOrFail();

        $serviceRequest->update(['status' => 'completed']);

        return response()->json(['message' => 'Mission terminée']);
    }
}