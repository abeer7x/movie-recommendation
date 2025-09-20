<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Recommendation;

class MovieController extends Controller
{
    public function showRecommendationForm()
    {
        $movies = Movie::all();
        return view('recommendation-form', compact('movies'));
    }

    public function getRecommendations(Request $request)
    {
        $movieIds = $request->input('movies');
        $recommendations = collect();

        foreach ($movieIds as $movieId) {
            $recommendation = Recommendation::where('movie_id', $movieId)
                ->where('algorithm', 'kmeans')
                ->first();

            if ($recommendation) {
                $recommendedMovies = json_decode($recommendation->recommended_movies);
                $recommendations = $recommendations->merge($recommendedMovies);
            }
        }

        $recommendedMovies = Movie::whereIn('id', $recommendations->unique()->take(10))->get();

        return view('recommended-movies', compact('recommendedMovies'));
    }

    public function showKMeansControl()
    {
        return view('kmeans-control');
    }

    public function applyKMeans(Request $request)
    {
        $k = $request->input('k', 5);
        $kmeansService = new \App\Services\KMeansService();
        $kmeansService->generateRecommendations($k);

        return redirect()->route('recommendation-form')->with('status', 'KMeans applied successfully with k=' . $k);
    }
}
