<?php

namespace QueueManager\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use QueueManager\Model\Task;
use QueueManager\Task\AbstractTask;

class QueueManager
{
    private AbstractTask $task;
    private ?Task $taskInQueue = null;

    public function dispatch(AbstractTask $task): void
    {
        Task::query()->create([
            'name' => get_class($task),
            'payload' => $task->serialize(),
            'status' => Task::STATUS_WAITING
        ]);
    }

    public function getTasks(int $pagination = 15): LengthAwarePaginator
    {
        return Task::query()->paginate($pagination);
    }

    public function setAwaitingTask(): bool
    {
        $this->taskInQueue = (new Task)->getFirstAwaitingTask();

        return (bool)$this->taskInQueue;
    }

    public function runTask(): bool
    {
        if (!$this->taskInQueue) {
            return true;
        }

        try {
            DB::beginTransaction();
            $task = unserialize($this->taskInQueue->payload);

            $task ? $task->handle() :
                throw new \Exception(' Error on payload ');

            $this->taskInQueue->done();
            DB::commit();

            return true;
        } catch (\Exception $exception) {

            DB::rollBack();
            $this->taskInQueue->failed();

            Log::error("The task in queue with id: " .
                $this->taskInQueue->id .
                " was not done. reason: " .
                $exception->getMessage()
            );

            return false;
        }
    }
}
