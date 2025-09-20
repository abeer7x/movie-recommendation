<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KMeansService;

class ApplyKMeans extends Command
{
    protected $signature = 'apply:kmeans {k}';
    protected $description = 'Apply KMeans algorithm for movie recommendations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $k = (int) $this->argument('k');

        if ($k <= 0) {
            $this->error('K must be a positive integer.');
            return;
        }

        $service = new KMeansService();
        try {
            $service->generateRecommendations($k);
            $this->info('KMeans clustering applied successfully.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
