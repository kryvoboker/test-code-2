<?php

declare(strict_types = 1);

namespace App\Contrancts\Telegram;

use Longman\TelegramBot\Entities\Update;

interface TelegramRouterInterface
{
    /**
     * @param array $classes
     *
     * @return void
     */
    public static function register(array $classes) : void;

    /**
     * @param Update $update
     *
     * @return bool
     */
    public static function dispatch(Update $update) : bool;
}
