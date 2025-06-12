<?php

declare(strict_types = 1);

namespace App\TelegramBot\Routers;

use App\Actions\Api\Telegram\SendMessageAction;
use App\Contrancts\Telegram\TelegramRouterInterface;
use App\TelegramBot\Commands\StartCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;

class CommandRouter implements TelegramRouterInterface
{
    /**
     * @var array<string, StartCommand>
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
             * @var StartCommand $command
             */
            $command = app($class);

            static::$commands[$command->getName()] = $command;
        }
    }

    /**
     * @param Update $update
     *
     * @return bool
     * @throws TelegramException
     */
    public static function dispatch(Update $update) : bool
    {
        $command = $update->getMessage()?->getCommand();

        if (!$command) {
            return false;
        }

        if (isset(static::$commands[$command])) {
            if (self::fireCallNotFromUserDirectly($update)) {
                return true;
            }

            static::$commands[$command]->handle($update);

            return true;
        }

        return false;
    }

    /**
     * @param Update $update
     *
     * @return bool
     * @throws TelegramException
     */
    private static function fireCallNotFromUserDirectly(Update $update) : bool
    {
        if (is_not_call_directly_from_user($update)) {
            SendMessageAction::run(get_telegram_chat_id($update), [
                'text'         => __('telegram/index.error_call_not_from_user_directly'),
                'reply_markup' => Keyboard::remove(),
            ]);

            return true;
        }

        return false;
    }
}
