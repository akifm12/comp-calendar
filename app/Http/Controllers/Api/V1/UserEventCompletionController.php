<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserEventCompletion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserEventCompletionController extends Controller
{
    /** Return all completed event keys for the authenticated user. */
    public function index(Request $request): JsonResponse
    {
        $completions = UserEventCompletion::where('user_id', $request->user()->id)
            ->orderByDesc('completed_at')
            ->get(['id', 'profile_id', 'event_key', 'notes', 'completed_at']);

        return response()->json(['data' => $completions]);
    }

    /** Toggle a completion on/off. Returns the new state. */
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'event_key'  => 'required|string|max:255',
            'profile_id' => 'nullable|integer',
            'notes'      => 'nullable|string|max:500',
        ]);

        $existing = UserEventCompletion::where('user_id', $request->user()->id)
            ->where('event_key', $request->event_key)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['completed' => false, 'event_key' => $request->event_key]);
        }

        $completion = UserEventCompletion::create([
            'user_id'    => $request->user()->id,
            'profile_id' => $request->profile_id,
            'event_key'  => $request->event_key,
            'notes'      => $request->notes,
        ]);

        return response()->json([
            'completed'    => true,
            'event_key'    => $completion->event_key,
            'completed_at' => $completion->completed_at->toIso8601String(),
        ], 201);
    }
}
