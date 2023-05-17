<?php

namespace QueueManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use QueueManager\Services\QueueManager;
use QueueManager\Task\RemoveInactiveUserTask;

class InactiveUserController extends Controller
{
    private QueueManager $queueManager;

    public function __construct(QueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function destroy(): JsonResponse
    {
        $this->queueManager->dispatch(new RemoveInactiveUserTask());

        return response()->json([
            'message' => 'Removing inactive users is running in background.'
        ]);
    }
}
