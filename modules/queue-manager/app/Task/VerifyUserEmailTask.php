<?php

namespace QueueManager\Task;

use App\Models\User;

class VerifyUserEmailTask extends AbstractTask
{
    private array $userIds;

    public function __construct(array $userIds)
    {
        $this->userIds = $userIds;
    }

    public function handle()
    {
        User::query()->whereIn('id',$this->userIds)->update([
           'email_verified_at' => now()
        ]);
    }
}
