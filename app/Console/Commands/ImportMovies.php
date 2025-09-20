<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use League\Csv\Reader;

class ImportMovies extends Command
{
    protected $signature = 'import:movies {file}';
    protected $description = 'Import movies from a CSV file';

    public function handle()
    {
        $file = $this->argument('file');

        // Delete records instead of truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Movie::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Import movies from the CSV file
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            Movie::create([
                'show_id' => $record['show_id'],
                'type' => $record['type'],
                'title' => $record['title'],
                'director' => $record['director'],
                'cast' => $record['cast'],
                'country' => $record['country'],
                'date_added' => \Carbon\Carbon::createFromFormat('d-M-y', $record['date_added']),
                'release_year' => $record['release_year'],
                'rating' => $record['rating'],
                'duration' => $record['duration'],
                'listed_in' => $record['listed_in'],
                'description' => $record['description'],
            ]);
        }

        $this->info('Movies imported successfully!');
    }
}
