<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AminUsersController;
use App\Http\Controllers\ServiceProvidersController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\UserReportsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AIAnalyzerController;

Route::get('/admin/dashboard', [DashboardController::class, 'showDashboard'])->name('admin.dashboard');

Route::get('/admin/UserReports', [UserReportsController::class, 'index'])->name('UserReports.index');
Route::put('/admin/UserReports/update/{reportID}', [UserReportsController::class, 'update'])->name('UserReports.update');

Route::get('/admin/requests', [RequestsController::class, 'index'])->name('requests.index');
Route::put('/admin/request/update/{requestID}', [RequestsController::class, 'update'])->name('request.update');

Route::get('/admin/service-providers', [ServiceProvidersController::class, 'index'])->name('service-providers.index');
Route::put('/service-providers/update/{providerID}', [ServiceProvidersController::class, 'update'])->name('service-providers.update');

Route::get('/admin/AminUsers', [AminUsersController::class, 'index'])->name('AminUsers.index');
Route::put('aminuser/update/{userID}', [AminUsersController::class, 'update'])->name('aminuser.update');

Route::get('/admin/Item', [ItemController::class, 'index'])->name('Item.index');
Route::put('/items/update', [ItemController::class, 'update'])->name('items.update');

Route::get('/ai-analyzer', [AIAnalyzerController::class, 'index'])->name('ai.index');
Route::post('/ai-analyzer/upload', [AIAnalyzerController::class, 'analyze'])->name('ai.analyze');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
