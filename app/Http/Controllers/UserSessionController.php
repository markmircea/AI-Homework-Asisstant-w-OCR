<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSessionController extends Controller
{
    public function getActiveSessions(Request $request)
{
    $sessions = DB::table('sessions')
        ->where('user_id', $request->user()->id)
        ->orderBy('last_activity', 'desc')
        ->get(['id', 'ip_address', 'last_activity', 'user_agent']);

    return response()->json($sessions);
}

    public function terminateSession(Request $request, $sessionId)
    {
        // Ensure the session belongs to the current user
        $session = DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($session) {
            // Delete the session
            DB::table('sessions')->where('id', $sessionId)->delete();
            return response()->json(['message' => 'Session terminated successfully']);
        }

        return response()->json(['message' => 'Session not found'], 404);
    }
}
