<?php

namespace QueueManager\Providers;

use Illuminate\Support\ServiceProvider;
use QueueManager\Commands\QueueTaskCommand;
use QueueManager\Services\QueueManager;

class QueueManagerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }

    /**
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(QueueManager::class, function () {
            return new QueueManager();
        });

        $this->commands(QueueTaskCommand::class);
    }
}
