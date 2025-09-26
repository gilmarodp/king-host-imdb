<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        return response()->json($user->favorites()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'movie_title' => 'required|string',
            'movie_poster' => 'nullable|string',
        ]);

        $user = Auth::user();

        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'movie_id' => $request->movie_id,
        ], [
            'movie_title' => $request->movie_title,
            'movie_poster' => $request->movie_poster,
        ]);

        return response()->json($favorite, 201);
    }

    public function destroy($movie_id): JsonResponse
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)
            ->where('movie_id', $movie_id)
            ->delete();

        return response()->json([], 204);
    }
}

