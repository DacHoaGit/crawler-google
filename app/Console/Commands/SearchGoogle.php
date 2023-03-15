<?php

namespace App\Console\Commands;

use App\Enums\SearchStatusEnum;
use App\Jobs\ProcessSearchGoogle;
use App\Models\Proxy;
use App\Models\Search;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Dachoagit\Search\Facade\SearchGoogle as SearchGG;


class SearchGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:search-google {status : The status value (0, 1 or -1)} {limit : The limit value}';

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
        $validator = Validator::make($this->arguments(), [
            'status' => ['in:0,1,-1'],
            'limit' => ['numeric'],
        ]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 1;
        }
        echo $this->argument('status');

        //list count search
        if (!is_null($this->argument('status')) && !is_null($this->argument('limit'))) {
            $this->line("Dang xu ly");

            $Searches = Search::where('status', $this->argument('status'))->limit($this->argument('limit'))->get();
            foreach ($Searches as $search) {
                ProcessSearchGoogle::dispatch($search)->onQueue('search');
            }
        }
        return Command::SUCCESS;
    }
}
