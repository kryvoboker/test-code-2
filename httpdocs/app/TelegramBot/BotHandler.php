<?php

declare(strict_types = 1);

namespace App\TelegramBot;

use App\Actions\Api\Telegram\SendMessageAction;
use App\Services\Telegram\TelegramService;
use App\Services\Telegram\TelegramStateService;
use App\Services\User\UserService;
use App\TelegramBot\Routers\CommandRouter;
use App\TelegramBot\Routers\KeyboardButtonRouter;
use Exception;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Throwable;

class BotHandler
{
    /**
     * @return void
     * @throws TelegramException
     */
    public function handle() : void
    {
        $update = $this->tryGetUpdate();

        if (!$update) {
            return;
        }

        $user_service = app(UserService::class);

        try {
            $user_service->fireSetUser($update);
        } catch (Exception $e) {
            Log::channel('stack')->error(
                $e->getMessage(),
                [
                    'update' => $update,
                ]
            );

            return;
        }

        $chat_id = get_telegram_chat_id($update);

        $locale = TelegramStateService::get(
            $chat_id,
            'locale'
        );

        if ($locale === null) {
            $locale = get_language_code_from_telegram($update);
        }

        if ($locale !== null && !in_array($locale, config('app.allowed_locales'))) {
            $locale = config('app.fallback_locale');
        }

        TelegramStateService::put(
            $chat_id,
            'locale',
            $locale
        );

        app()->setLocale($locale);

        $telegram_message_params = app(TelegramService::class)->getTelegramMessageParamsByValidationUserBlocked();

        if ($telegram_message_params) {
            SendMessageAction::run(
                $chat_id,
                $telegram_message_params
            );

            return;
        }

        if (
            $update->getMessage()?->getText() === null &&
            $update->getMessage()?->getCommand() === null
        ) {
            SendMessageAction::run($chat_id, [
                'text' => __('telegram/index.text_support_only_text'),
            ]);

            return;
        }

        if (!CommandRouter::dispatch($update)) {
            KeyboardButtonRouter::dispatch($update);
        }
    }

    /**
     * @return Update|void|null
     * @throws TelegramException
     */
    private function tryGetUpdate()
    {
        if (config('app.env') == 'local') {
            $telegram = new Telegram(
                config('telegram.bot_token'),
                config('telegram.bot_name')
            )->useGetUpdatesWithoutDatabase();

            $response = $telegram->handleGetUpdates();

            /**
             * We need only the first update
             *
             * @var Update|null $update
             */
            $update = ($response->getResult()[0] ?? null);
        } else {
            new Telegram(
                config('telegram.bot_token'),
                config('telegram.bot_name')
            )->useGetUpdatesWithoutDatabase();

            $raw     = file_get_contents('php://input');
            $payload = json_decode($raw, true);

            try {
                $update = new Update($payload);
            } catch (Throwable $e) {
                Log::channel('stack')->error($e->getMessage(), [
                    'payload' => $payload,
                    'raw'     => $raw,
                    'trace'   => $e->getTrace(),
                ]);

                http_response_code(400);

                fwrite(STDERR, "Invalid update\n");

                exit(1);
            }
        }

        return $update;
    }
}
