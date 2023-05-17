<?php

namespace QueueManager\Task;

use App\Models\User;

class RemoveInactiveUserTask extends AbstractTask
{

    public function handle()
    {
        /**
         * for this example we can take 10 users at one time and doing process without
         * any database issues, we also can use one record to update each time
         * $inactiveUsers = User::query()->where('active', false)->first();
         */
        $inactiveUsers = User::query()->where('active', false)->take(10);

        $inactiveUsers->delete();

        if(User::query()->where('active',false)->exists()){
            $this->dispatch();
        }
    }
}
