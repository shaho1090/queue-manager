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

    public function seek(): bool
    {
        $this->taskInQueue = (new Task)->getFirstAwaitingTask();

        return (bool)$this->taskInQueue;
    }

    public function run(): void
    {
        if (!$this->taskInQueue) {
            return;
        }

        try {
            DB::beginTransaction();

            $task = unserialize($this->taskInQueue->payload);

            $task->handle();

            $this->taskInQueue->makeDone();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("The task in queue with id: " .
                $this->taskInQueue->id .
                " was not done. reason: ".
                $exception->getMessage()
            );
        }
    }
}
