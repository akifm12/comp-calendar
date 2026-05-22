<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LicenseActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LicenseActivityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate(['regulator_id' => 'nullable|integer|exists:regulators,id']);
        $query = LicenseActivity::active()->with('suggestedRegulator');
        if ($request->filled('regulator_id')) {
            $query->where('suggested_regulator_id', $request->regulator_id);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        return response()->json([
            'data' => $query->orderBy('name')->get()->map(fn ($a) => [
                'id'                       => $a->id,
                'name'                     => $a->name,
                'description'              => $a->description,
                'sector'                   => $a->sector,
                'suggested_regulator_id'   => $a->suggested_regulator_id,
                'additional_regulator_ids' => $a->additional_regulator_ids,
                'suggested_regulator'      => $a->suggestedRegulator,
            ]),
        ]);
    }
}
