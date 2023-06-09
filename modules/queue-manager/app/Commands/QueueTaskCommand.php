<?php

namespace QueueManager\Commands;


use Illuminate\Console\Command;
use QueueManager\Services\QueueManager;
use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

class QueueTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task-queue:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run queue manager to fetch and implement the tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var QueueManager $queueManager */
        $queueManager = app(QueueManager::class);

        $loop = Loop::get();

        $loop->addPeriodicTimer(0.2, function (TimerInterface $timer) use ($loop, $queueManager) {

            if ($queueManager->setAwaitingTask()) {
                echo 'Task is running...';
                echo PHP_EOL;

                if ($queueManager->runTask()) {
                    echo 'Task processed.';
                } else {
                    echo 'Something went wrong please check the log file.';
                }

                echo PHP_EOL;
            }

            /**
             * in case you want to stop running queue process after all tasks are finished
             *
             *  if ($queueManager->seek()) {
             *      echo 'task is running...';
             *      echo PHP_EOL;
             *      $queueManager->run();
             *      echo 'task processed.';
             *      echo PHP_EOL;
             *    } else {
             *      $loop->cancelTimer($timer);
             *      echo 'running task ends!';
             *      echo PHP_EOL;
             *    }
             */
        });

        $loop->run();
    }
}
