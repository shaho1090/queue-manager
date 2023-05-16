<?php

namespace QueueManager\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QueueManager\Task\AbstractTask;

/**
 * @property string $name
 * @property string $payload
 * @property string $status
 * @property int $id
 */
class Task extends Model
{
    use HasFactory;

    const STATUS_WAITING = 'waiting';
    const STATUS_FINISHED = 'finished';

    protected $fillable = [
        'name',
        'payload',
        'status'
    ];

    public function getAwaitingTask()
    {
        return $this->query()->where('status', 'waiting')->first();
    }

    public function makeDone(): bool
    {
        return $this->update([
            'status' => self::STATUS_FINISHED
        ]);
    }
}
