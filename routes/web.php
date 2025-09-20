<?php

//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\MovieController;
//
//Route::get('/', [MovieController::class, 'showRecommendationForm'])->name('recommendation-form');
//Route::post('/recommendations', [MovieController::class, 'getRecommendations'])->name('get-recommendations');
//Route::get('/kmeans-control', [MovieController::class, 'showKMeansControl'])->name('kmeans-control');
//Route::post('/apply-kmeans', [MovieController::class, 'applyKMeans'])->name('apply-kmeans');
//



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MovieAprioriController;
use App\Http\Controllers\AprioriParametersController;

// واجهة الترحيب
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// راوتات KMeans
Route::get('/kmeans', [MovieController::class, 'showRecommendationForm'])->name('recommendation-form');
Route::post('/recommendations', [MovieController::class, 'getRecommendations'])->name('get-recommendations');
Route::get('/kmeans-control', [MovieController::class, 'showKMeansControl'])->name('kmeans-control');
Route::post('/apply-kmeans', [MovieController::class, 'applyKMeans'])->name('apply-kmeans');

// راوتات Apriori
Route::get('/parameters', function () {
    return view('index');
})->name('parameters');
Route::post('/store-parameters', [AprioriParametersController::class, 'store']);
Route::get('/recommendbyGenreByName', [MovieAprioriController::class, 'show'])->name('getRecommendation');
Route::post('/recommendbyGenreByName', [MovieAprioriController::class, 'recommendUsingName'])->name('recommendbyGenreByName');
