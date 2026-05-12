<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/v1/admin/users
    public function index()
    {
        $users = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($users);
    }

    // PUT /api/v1/admin/users/{id}/toggle
    public function toggle($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'message'   => $user->is_active ? 'Compte activé' : 'Compte désactivé',
            'is_active' => $user->is_active,
        ]);
    }

    // DELETE /api/v1/admin/users/{id}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Compte supprimé']);
    }
}