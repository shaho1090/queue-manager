<?php

use Illuminate\Support\Facades\Route;
use QueueManager\Http\Controllers\InactiveUserController;
use QueueManager\Http\Controllers\TaskQueueController;
use QueueManager\Http\Controllers\UserEmailController;

Route::delete('/users/inactive/delete',[InactiveUserController::class,'destroy'])
    ->name('users.inactive.delete');

Route::post('/users/email/verify',[UserEmailController::class,'verify'])
    ->name('users.email.verify');

Route::get('/tasks',[TaskQueueController::class,'index'])
    ->name('task.index');
