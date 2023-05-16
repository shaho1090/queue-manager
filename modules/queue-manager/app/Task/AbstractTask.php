<?php

namespace QueueManager\Task;

use QueueManager\Services\QueueManager;

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
}
