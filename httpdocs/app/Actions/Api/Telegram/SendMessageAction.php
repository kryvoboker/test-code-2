<?php

declare(strict_types = 1);

namespace App\Actions\Api\Telegram;

use App\Actions\Trait\ActionCommonMethodsTrait;
use App\Contrancts\Action\ActionInterface;
use App\Services\Api\Telegram\ApiTelegramService;
use Exception;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class SendMessageAction implements ActionInterface
{
    use ActionCommonMethodsTrait;

    /**
     * @return ServerResponse|null
     *
     * @throws TelegramException
     * @throws Exception
     */
    public function handle() : ?ServerResponse
    {
        $total_args = func_num_args();

        if ($total_args < 2) {
            $this->resolveCountArgsError(2, $total_args);
        }

        $args = func_get_args();

        $chat_id = $args[0] ?? null;
        $params  = $args[1] ?? [];

        if ($chat_id === null) {
            throw new Exception(
                __('telegram/index.error_chat_id')
            );
        }

        return app(ApiTelegramService::class)->sendMessage((int)$chat_id, $params);
    }

    /**
     * @inheritDoc
     *
     * @throws TelegramException
     */
    public static function run(...$args) : ?ServerResponse
    {
        return new static()->handle(...$args);
    }
}
