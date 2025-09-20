<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Recommendation;

class KMeansService
{
    public function generateRecommendations($k)
    {
        $movies = Movie::all(['id', 'release_year', 'rating', 'duration']);

        if ($movies->isEmpty()) {
            throw new \Exception("No movies found in the database.");
        }

        $data = $movies->map(function($movie) {
            return [
                $movie->release_year,
                $this->ratingToNumeric($movie->rating),
                $this->durationToMinutes($movie->duration)
            ];
        })->toArray();

        $numDimensions = count($data[0]);
        foreach ($data as $dataPoint) {
            if (count($dataPoint) != $numDimensions) {
                throw new \Exception("Inconsistent data dimensions found.");
            }
        }

        $maxIterations = 100;
        $centroids = $this->initializeCentroids($data, $k);
        $clusters = [];

        for ($i = 0; $i < $maxIterations; $i++) {
            $clusters = $this->assignClusters($data, $centroids);

            foreach ($clusters as $cluster) {
                if (empty($cluster)) {
                    $centroids = $this->initializeCentroids($data, $k);
                    continue 2;
                }
            }

            $newCentroids = $this->calculateCentroids($clusters, $data);

            if ($this->centroidsConverged($centroids, $newCentroids)) {
                break;
            }

            $centroids = $newCentroids;
        }

        foreach ($clusters as $cluster) {
            foreach ($cluster as $movieIndex) {
                $movieId = $movies[$movieIndex]->id;
                $recommendedMovies = array_diff($cluster, [$movieIndex]);

                $recommendedMovies = array_slice($recommendedMovies, 0, 10);

                Recommendation::updateOrCreate(
                    ['movie_id' => $movieId, 'algorithm' => 'kmeans'],
                    ['recommended_movies' => json_encode($recommendedMovies)]
                );
            }
        }

        return $clusters;
    }

    private function ratingToNumeric($rating)
    {
        $ratings = [
            'G' => 1,
            'PG' => 2,
            'PG-13' => 3,
            'R' => 4,
            'NC-17' => 5,
            'NR' => 6,
            'UR' => 7,
            'TV-G' => 8,
            'TV-PG' => 9,
            'TV-14' => 10,
            'TV-MA' => 11
        ];

        return $ratings[$rating] ?? 0;
    }

    private function durationToMinutes($duration)
    {
        if (str_ends_with($duration, 'min')) {
            return (int) $duration;
        } elseif (str_ends_with($duration, 'season')) {
            return (int) $duration * 60 * 10;
        }

        return 0;
    }

    private function initializeCentroids($data, $k)
    {
        $centroids = [];
        $dataCount = count($data);

        for ($i = 0; $i < $k; $i++) {
            $centroids[] = $data[rand(0, $dataCount - 1)];
        }

        return $centroids;
    }

    private function assignClusters($data, $centroids)
    {
        $clusters = array_fill(0, count($centroids), []);

        foreach ($data as $dataIndex => $dataPoint) {
            $closestCentroidIndex = $this->getClosestCentroid($dataPoint, $centroids);
            $clusters[$closestCentroidIndex][] = $dataIndex;
        }

        return $clusters;
    }

    private function getClosestCentroid($dataPoint, $centroids)
    {
        $closestCentroidIndex = 0;
        $closestDistance = $this->calculateDistance($dataPoint, $centroids[0]);

        foreach ($centroids as $centroidIndex => $centroid) {
            $distance = $this->calculateDistance($dataPoint, $centroid);
            if ($distance < $closestDistance) {
                $closestDistance = $distance;
                $closestCentroidIndex = $centroidIndex;
            }
        }

        return $closestCentroidIndex;
    }

    private function calculateDistance($point1, $point2)
    {
        if (count($point1) != count($point2)) {
            throw new \Exception("Dimension mismatch between points.");
        }

        $distance = 0;

        for ($i = 0; $i < count($point1); $i++) {
            if (!isset($point2[$i])) {
                throw new \Exception("Undefined array key $i in point2.");
            }
            $distance += pow($point1[$i] - $point2[$i], 2);
        }

        return sqrt($distance);
    }

    private function calculateCentroids($clusters, $data)
    {
        $centroids = [];

        foreach ($clusters as $cluster) {
            $centroid = array_fill(0, count($data[0]), 0);

            foreach ($cluster as $dataIndex) {
                foreach ($data[$dataIndex] as $dimIndex => $value) {
                    $centroid[$dimIndex] += $value;
                }
            }

            foreach ($centroid as $dimIndex => $value) {
                if (count($cluster) > 0) {
                    $centroid[$dimIndex] /= count($cluster);
                }
            }

            $centroids[] = $centroid;
        }

        return $centroids;
    }

    private function centroidsConverged($centroids, $newCentroids)
    {
        for ($i = 0; $i < count($centroids); $i++) {
            if ($this->calculateDistance($centroids[$i], $newCentroids[$i]) > 0.001) {
                return false;
            }
        }

        return true;
    }
}
