<?php

namespace QueueManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use QueueManager\Http\Resources\TaskCollection;
use QueueManager\Services\QueueManager;

class TaskQueueController extends Controller
{
    private QueueManager $queueManager;

    public function __construct(QueueManager $queueManager)
    {
        $this->queueManager = $queueManager;
    }

    public function index(): JsonResponse
    {
        $tasks = $this->queueManager->getTasks(10);

        return response()->json(new TaskCollection($tasks));
    }
}
