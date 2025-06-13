<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\Telegram\TelegramController;
use App\Http\Controllers\Api\Trello\TrelloController;
use App\Http\Middleware\Api\TelegramApiAuth;
use App\Http\Middleware\Api\TrelloApiAuth;

Route::post('/telegram', [TelegramController::class, 'handle'])
    ->middleware(TelegramApiAuth::class)
    ->name('telegram.handle');

Route::get('/trello-webhook-list', [TrelloController::class, 'returnStatusOk'])
    ->name('trello.webhook.list.return-status-ok');

Route::post('/trello-webhook-list', [TrelloController::class, 'handleList'])
    ->middleware(TrelloApiAuth::class)
    ->name('trello.webhook.list.handle-list');
