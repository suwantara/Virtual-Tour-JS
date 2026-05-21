<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\VenueResource;
use App\Services\VenueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TourApiController extends Controller
{
    public function __construct(private VenueService $venueService) {}

    public function index(): AnonymousResourceCollection
    {
        return VenueResource::collection($this->venueService->getPublished());
    }

    public function show(string $slug): VenueResource|JsonResponse
    {
        $venue = $this->venueService->findBySlugForApi($slug);

        if (! $venue) {
            return response()->json(['message' => 'Venue not found.'], 404);
        }

        return new VenueResource($venue);
    }
}
