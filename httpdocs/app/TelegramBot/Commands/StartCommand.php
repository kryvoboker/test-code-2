<?php

declare(strict_types = 1);

namespace App\TelegramBot\Commands;

use App\Actions\Api\Telegram\SendMessageAction;
use App\Contrancts\Telegram\TelegramCommandInterface;
use App\Enums\Telegram\TelegramCommandEnum;
//use App\TelegramBot\Keyboards\Replies\MainMenuKeyboard;
use Exception;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;

class StartCommand implements TelegramCommandInterface
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return TelegramCommandEnum::Start->value;
    }

    /**
     * @param Update $update
     *
     * @return void
     * @throws TelegramException
     * @throws Exception
     */
    public function handle(Update $update) : void
    {
        $params = [
            'text'         => __('telegram/index.text_start_command_text', [
                'user_name' => get_telegram_user_firstname($update)
            ]),
//            'reply_markup' => app(MainMenuKeyboard::class)->getKeyboard(),
            'parse_mode'   => 'HTML',
        ];

        SendMessageAction::run(
            get_telegram_chat_id($update),
            $params
        );
    }
}
