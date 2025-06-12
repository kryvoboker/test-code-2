<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Services\Api\Telegram\ApiTelegramService;
use App\Services\Telegram\TelegramService;
use App\Services\User\UserService;
use App\TelegramBot\Commands\StartCommand;
use App\TelegramBot\KeyboardButtons\Report\ReportButton;
use App\TelegramBot\Routers\CommandRouter;
use App\TelegramBot\Routers\KeyboardButtonRouter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->singleton(UserService::class);
        $this->app->singleton(ApiTelegramService::class);
        $this->app->singleton(TelegramService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() : void
    {
        require_once app_path('Supports/helper.php');

        CommandRouter::register([
            StartCommand::class,
        ]);

        KeyboardButtonRouter::register([
            ReportButton::class,
        ]);
    }
}
