<?php

namespace QueueManager\Task;

use QueueManager\Services\QueueManager;

/**
 * if you want to add more tasks and to run with QueueManger
 * you can make new class extended this class,
 * add its dependency with __construct method
 * and put your logic inside handle method 
 */
abstract class AbstractTask
{
    private ?QueueManager $queueManager = null;

    abstract public function handle();

    public function dispatch(): void
    {
        $this->qetQueueManager()->dispatch($this);
    }

    protected function qetQueueManager(): QueueManager
    {
        if (is_null($this->queueManager)) {
            $this->setQueueManager();
        }

        return $this->queueManager;
    }

    private function setQueueManager(): void
    {
        $this->queueManager = new QueueManager();
    }

    public function serialize(): string
    {
        return serialize($this);
    }
}
