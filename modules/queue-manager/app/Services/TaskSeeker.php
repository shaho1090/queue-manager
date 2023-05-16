<?php

namespace QueueManager\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use QueueManager\Model\Task;

class TaskSeeker
{
    private ?Task $taskInQueue = null;

    public function seek(): bool
    {
        $this->taskInQueue = (new Task)->getAwaitingTask();

        return (bool)$this->taskInQueue;
    }

    public function run(): void
    {
        if (!$this->taskInQueue) {
            return;
        }

        try{
            DB::beginTransaction();

            $task = new $this->taskInQueue->name($this->taskInQueue->payload);
            $task->handle();

            $this->taskInQueue->makeDone();

            DB::commit();
        }catch(\Exception $exception){
            DB::rollBack();
            Log::error("The task in queue with id: ".$this->taskInQueue->id." was not done");
        }
    }
}
