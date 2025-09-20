<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendationController extends Controller
{
    public function index()
    {
        return view('recommendations');
    }

    public function getRecommendations(Request $request)
    {
        $movieIds = explode(',', $request->input('movies'));
        $recommendations = [];

        foreach ($movieIds as $movieId) {
            $movieId = (int)trim($movieId);
            $recs = DB::table('recommendations')
                ->where('movie_id', $movieId)
                ->pluck('recommendation_data');

            foreach ($recs as $rec) {
                $recommendations = array_merge($recommendations, json_decode($rec, true));
            }
        }

        $uniqueRecommendations = array_unique($recommendations);

        return view('recommendations', ['recommendations' => $uniqueRecommendations]);
    }
}
