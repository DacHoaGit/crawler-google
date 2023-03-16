<?php

namespace App\Console\Commands;

use App\Models\Search;
use Dachoagit\Search\Jobs\ProcessSearchGoogle;
use Illuminate\Console\Command;


class SearchGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search-google:run {--status= : The status pending, false, success } {--limit=: The limit value}';
    private $arrStatus = [
        "success" => 1,
        "pending" => 0,
        "false" => -1
    ];
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description Google';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit') ?? 10;
        $status = strtolower($this->option('status'));
        $status = $this->arrStatus[$status];
        $this->info($status);

        if ($status && $limit) {
            $this->line("Dang xu ly");

            $Searches = Search::where('status', $status)->limit($limit)->get();
            foreach ($Searches as $search) {
                ProcessSearchGoogle::dispatch($search)->onQueue('search');
//            }
            }
            return Command::SUCCESS;
        }

    }
}



