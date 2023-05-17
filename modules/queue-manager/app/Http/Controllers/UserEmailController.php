<?php

namespace QueueManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use QueueManager\Http\Requests\VerifyUserEmail;
use QueueManager\Services\QueueManager;
use QueueManager\Task\RemoveInactiveUserTask;
use QueueManager\Task\VerifyUserEmailTask;

class UserEmailController extends Controller
{
    private QueueManager $queueManager;

    public function __construct(QueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function verify(VerifyUserEmail $request): JsonResponse
    {
        $this->queueManager->dispatch(new VerifyUserEmailTask($request->get('user_ids')));

        return response()->json([
            'message' => 'Verifying user emails is running in background.'
        ]);
    }
}
