<?php

use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EmailTemplateController;
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
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');


    Route::get('/user-list', [UserController::class, 'index'])->name('user.list');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user-import', [UserController::class, 'import'])->name('user.import');
    Route::get('/user-export', [UserController::class, 'export'])->name('user.export');
    Route::patch('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user-destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user-delete-selected', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');


    Route::get('/task-list', [TaskController::class, 'index'])->name('task.list');
    Route::get('/task-add', [TaskController::class, 'addIndex'])->name('task.add');
    Route::post('/task-store', [TaskController::class, 'store'])->name('task.store');
    Route::post('/task-join/{id}', [TaskController::class,'join'])->name('task.join');

    Route::get('/task-detail/{id}', [TaskController::class, 'detail'])->name('task.detail');

    Route::get('/task-update-index/{id}', [TaskController::class, 'updateIndex'])->name('task.update.index');
    Route::patch('/task-update/{id}', [TaskController::class, 'update'])->name('task.update');

    Route::delete('/task-destroy/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::post('/task-delete-selected', [TaskController::class, 'destroySelected'])->name('task.deleteSelected');


    Route::get('/email-template-list', [EmailTemplateController::class, 'index'])->name('email.template.list');
    Route::get('/email-template-detail-index/{id}', [EmailTemplateController::class, 'detailIndex'])->name('email.template.detail.index');
    Route::get('/email-template-update-index/{id}', [EmailTemplateController::class, 'updateIndex'])->name('email.template.update.index');
    Route::post('/email-template-store', [EmailTemplateController::class, 'store'])->name('email.template.store');
    Route::delete('/email-template-delete/{id}', [EmailTemplateController::class, 'delete'])->name('email.template.delete');
    Route::post('/email-template-delete-selected', [EmailTemplateController::class, 'deleteSelected'])->name('email.template.deleteSelected');
    Route::patch('/email-template-update/{id}', [EmailTemplateController::class, 'update'])->name('email.template.update');

    Route::get('/email-campaign-list', [EmailCampaignController::class, 'index'])->name('email.campaign.list');
    Route::post('/email-campaign-store', [EmailCampaignController::class, 'store'])->name('email.campaign.store');
    Route::delete('/email-campaign-destroy/{id}', [EmailCampaignController::class, 'destroy'])->name('email.campaign.destroy');
    Route::post('/email-campaign-delete-selected', [EmailCampaignController::class, 'destroySelected'])->name('email.campaign.deleteSelected');
    Route::get('/email-campaign-update-index/{id}', [EmailCampaignController::class, 'updateIndex'])->name('email.campaign.update.index');
    Route::get('/email-campaign-detail-index/{id}', [EmailCampaignController::class, 'detailIndex'])->name('email.campaign.detail.index');
    Route::patch('/email-campaign-update/{id}', [EmailCampaignController::class, 'update'])->name('email.campaign.update');


    Route::get('/logs', [LogController::class, 'showLogs'])->name('logs');



});



require __DIR__.'/auth.php';
