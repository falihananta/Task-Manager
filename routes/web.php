<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Redirect root to tasks index
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Home route redirect
Route::get('/home', function () {
    return redirect()->route('tasks.index');
})->name('home');

// Profile route
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

// Tasks resource routes (includes index, create, store, show, edit, update, destroy)
Route::resource('tasks', TaskController::class);

// AJAX routes for tasks
Route::post('/tasks/delete-ajax', [TaskController::class, 'deleteAjax'])->name('tasks.delete.ajax');
Route::post('/tasks/toggle-complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggle.complete');