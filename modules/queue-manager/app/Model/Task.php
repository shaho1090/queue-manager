<?php

namespace QueueManager\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'name',
        'payload',
        'status'
    ];

    public function getFirstAwaitingTask()
    {
        return $this->query()->where('status', 'waiting')->first();
    }

    public function done(): bool
    {
        return $this->update([
            'status' => self::STATUS_FINISHED
        ]);
    }

    public function failed(): bool
    {
        return $this->update([
            'status' => self::STATUS_FAILED
        ]);
    }
}
