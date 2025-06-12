<?php

use App\Http\Controllers\Api\Telegram\TelegramController;
use App\Http\Middleware\Api\TelegramApiAuth;

Route::post('/telegram', [TelegramController::class, 'handle'])
    ->middleware(TelegramApiAuth::class)
    ->name('telegram.handle');
