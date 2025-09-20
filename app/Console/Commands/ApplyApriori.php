<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AprioriService;
use App\Models\AprioriParameters; 


class ApplyApriori extends Command
{
    protected $signature = 'apply:apriori';
    protected $description = 'Apply the Apriori algorithm to generate movie recommendations';

    protected $aprioriService;

    public function __construct(AprioriService $aprioriService)
    {
        parent::__construct();

        $this->aprioriService = $aprioriService;
    }

    public function handle()
    {
        $parameters = AprioriParameters::latest()->first();

        if ($parameters) {
            $this->aprioriService->generateRecommendations($parameters->support, $parameters->confidence);
            $this->info('Apriori recommendations applied successfully!');
        } else {
            $this->error('No parameters found. Please store the parameters first.');
        }
    }
}

