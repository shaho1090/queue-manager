<?php

namespace QueueManager\Commands;


use Illuminate\Console\Command;
use QueueManager\Services\TaskSeeker;
use React\EventLoop\Loop;
use React\EventLoop\TimerInterface;

class QueueTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-task:run';

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
        $loop = Loop::get();

        $loop->addPeriodicTimer(0.2, function (TimerInterface $timer) use ($loop) {
            $taskSeeker = new TaskSeeker();

            /** in case you want to not stop the worker */
            //$taskSeeker->seek();
            //$taskSeeker->run();

            if ($taskSeeker->seek()) {
                $taskSeeker->run();
                echo 'task is running...';
                echo PHP_EOL;
            } else {
                $loop->cancelTimer($timer);
                echo 'running task ends!';
                echo PHP_EOL;
            }
        });

        $loop->run();
    }
}
