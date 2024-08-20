<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;

Route::get('ads', [AdController::class, 'index']);
Route::get('ads/{id}', [AdController::class, 'show']);
Route::post('ads', [AdController::class, 'store']);
