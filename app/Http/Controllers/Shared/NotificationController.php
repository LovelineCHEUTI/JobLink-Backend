<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // GET /api/v1/notifications
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    // PUT /api/v1/notifications/{id}/read
    public function markAsRead($id)
    {
        Notification::findOrFail($id)->update(['is_read' => true]);
        return response()->json(['message' => 'Notification lue']);
    }

    // PUT /api/v1/notifications/read-all
    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', $request->user()->id)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'Toutes les notifications lues']);
    }
}