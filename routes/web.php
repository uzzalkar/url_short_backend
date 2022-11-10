<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectUrlController;

Route::get('/{url_id}', [RedirectUrlController::class, 'index']);
Route::get('/{something?}/{url_id}', [RedirectUrlController::class, 'index'])->where('something', '.*');
