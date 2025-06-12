<?php

declare(strict_types = 1);

namespace App\TelegramBot\Routers;

use App\Contrancts\Telegram\TelegramRouterInterface;
use App\TelegramBot\KeyboardButtons\Report\ReportButton;
use Longman\TelegramBot\Entities\Update;

class KeyboardButtonRouter implements TelegramRouterInterface
{
    /**
     * @var array<string, ReportButton>
     */
    protected static array $commands = [];

    /**
     * @param array $classes
     *
     * @return void
     */
    public static function register(array $classes) : void
    {
        foreach ($classes as $class) {
            /**
             * @var ReportButton $button
             */
            $button = app($class);

            static::$commands[$button->getName()] = $button;
        }
    }

    /**
     * @param Update $update
     *
     * @return bool
     */
    public static function dispatch(Update $update) : bool
    {
        foreach (static::$commands as $command) {
            if ($command->isThisButtonPressed($update)) {
                $command->handle($update);

                return true;
            }
        }

        return false;
    }
}
