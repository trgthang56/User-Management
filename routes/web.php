<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/admin', function () {
//     return view('auth/login');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');


    Route::get('/user-list', [UserController::class, 'index'])->name('user.list');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::patch('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user-destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user-delete-selected', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');


    Route::get('/task-list', [TaskController::class, 'index'])->name('task.list');
    Route::get('/task-add', [TaskController::class, 'addIndex'])->name('task.add');
    Route::post('/task-store', [TaskController::class, 'store'])->name('task.store');
    Route::post('/task-join/{id}', [TaskController::class,'join'])->name('task.join');
    Route::get('/task-update-index/{id}', [TaskController::class, 'updateIndex'])->name('task.update.index');
    Route::patch('/task-update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task-destroy/{id}', [TaskController::class, 'destroy'])->name('task.destroy');

    Route::get('/logs', [LogController::class, 'showLogs'])->name('logs');



});



require __DIR__.'/auth.php';
