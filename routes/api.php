<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CaseHandleAPIController;
use App\Http\Controllers\Api\APIController;

Route::post('/contacts', [ContactController::class, 'store']);
Route::post('/cases', [CaseHandleAPIController::class, 'store']);
Route::get('/cases/get-all-datas', [CaseHandleAPIController::class, 'index'])->name('api.cases.data');
Route::get('/request-change/schedule', [APIController::class, 'scheduleIndex']);
Route::get('/request-change/{id}', [APIController::class, 'showSchedule']);
Route::post('/request-change/complete', [APIController::class, 'completeRequest'])->name('request-change.complete');