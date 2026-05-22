<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserCustomDeadline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCustomDeadlineController extends Controller
{
    /** List all custom deadlines for the authenticated user. */
    public function index(Request $request): JsonResponse
    {
        $deadlines = UserCustomDeadline::where('user_id', $request->user()->id)
            ->orderBy('due_date')
            ->get();

        return response()->json(['data' => $deadlines]);
    }

    /** Create a new custom deadline. */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profile_id'   => 'nullable|integer',
            'title'        => 'required|string|max:255',
            'due_date'     => 'required|date',
            'notes'        => 'nullable|string|max:1000',
            'category'     => 'nullable|string|max:100',
            'is_recurring' => 'nullable|boolean',
            'recurrence'   => 'nullable|string|in:monthly,quarterly,annual',
        ]);

        $deadline = UserCustomDeadline::create([
            'user_id'      => $request->user()->id,
            'profile_id'   => $validated['profile_id'] ?? null,
            'title'        => $validated['title'],
            'due_date'     => $validated['due_date'],
            'notes'        => $validated['notes'] ?? null,
            'category'     => $validated['category'] ?? 'Custom',
            'is_recurring' => $validated['is_recurring'] ?? false,
            'recurrence'   => $validated['recurrence'] ?? null,
        ]);

        return response()->json(['data' => $deadline], 201);
    }

    /** Update an existing custom deadline (owner-only). */
    public function update(Request $request, UserCustomDeadline $customDeadline): JsonResponse
    {
        if ($customDeadline->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|string|max:255',
            'due_date'     => 'sometimes|date',
            'notes'        => 'nullable|string|max:1000',
            'category'     => 'nullable|string|max:100',
            'is_recurring' => 'nullable|boolean',
            'recurrence'   => 'nullable|string|in:monthly,quarterly,annual',
        ]);

        $customDeadline->update($validated);

        return response()->json(['data' => $customDeadline]);
    }

    /** Delete a custom deadline (owner-only). */
    public function destroy(Request $request, UserCustomDeadline $customDeadline): JsonResponse
    {
        if ($customDeadline->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $customDeadline->delete();

        return response()->json(['message' => 'Deleted'], 200);
    }
}
