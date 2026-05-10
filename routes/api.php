<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DestinationsController;

Route::get('/destinations', [DestinationsController::class, 'index']);
