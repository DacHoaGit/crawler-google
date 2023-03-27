<?php

namespace App\Listeners;

use App\Enums\ResultStatusEnum;
use App\Models\Result;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Queue\InteractsWithQueue;

class DetectQueuedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }


    public function handle(JobQueued $event)
    {
        $queueName = 'auto-crawl.crawler.update-link-status'; // Tên queue cần lắng nghe

//        $job = $event->job;
//
//        $queue = $job->getQueue();
//
//        if ($queue === $queueName) {
//            $data = json_decode($job->getData())->getContent();
//            $link = $data->link;
//            $status = $data->status;
//            $result = Result::where('link',$link)->first();
//            $result->status = $status;
//            $result->save();
//        }
    }
}
