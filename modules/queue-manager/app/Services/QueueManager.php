<?php

namespace QueueManager\Services;

use QueueManager\Model\Task;
use QueueManager\Task\AbstractTask;
use ReflectionClass;

class QueueManager
{
    private AbstractTask $task;

    public function dispatch(AbstractTask $task): void
    {
        $class = new ReflectionClass($task);
        $constructor = $class->getConstructor();

        Task::query()->create([
            'name' => get_class($task),
            'payload' => $constructor,
            'status' => Task::STATUS_WAITING
        ]);
    }
}
