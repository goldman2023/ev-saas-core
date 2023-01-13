<?php

use App\Http\Controllers\TaskController;

/* Tasks */
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
Route::get('/task/details/{id}', [TaskController::class, 'details'])->name('task.details');
Route::get('/tasks/destroy/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
Route::get('/tasks/completed/{id}', [TaskController::class, 'completed'])->name('task.completed');