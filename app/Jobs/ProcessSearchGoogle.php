<?php

namespace App\Jobs;

use App\Models\Proxy;
use App\Models\Search;
use Dachoagit\Search\Facade\SearchGoogle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ProcessSearchGoogle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Search $search;

    /**
     * Create a new job instance.
     */
    public function __construct(Search $search)
    {
        $this->search = $search;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $res = SearchGoogle::inputSearch($this->search->content);
            $jsonContent = json_decode($res->getContent());
            $statusCode = json_decode($res->getStatusCode());


            if (isset($jsonContent->success)) {
                foreach ($jsonContent->success as $each) {
                    $this->search->results()->updateOrCreate(['link' => $each]);
//                echo $each . PHP_EOL;
                }
                $this->search->status = 1;
                $this->search->save();
                echo 'Success' . PHP_EOL;
            } else if (($jsonContent->error)) {

                $this->search->status = -1;
                $this->search->error = $jsonContent->error;
                $this->search->save();
                Log::error('Job failed: ' . $jsonContent->error);
            }
        } catch (\Throwable $exception) {
            $this->search->status = -1;
            $this->search->error = $exception->getMessage();
            $this->search->save();
            Log::error('Job failed: ' . $exception->getMessage());
        }
    }
}
