<?php

declare(strict_types = 1);

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Longman\TelegramBot\Entities\Update;

if (!function_exists('get_telegram_chat_id')) {
    /**
     * @param Update $update
     *
     * @return int|null
     */
    function get_telegram_chat_id(Update $update) : ?int
    {
        return $update->getMessage()?->getChat()->getId() ?? $update->getCallbackQuery()?->getMessage()->getChat()->getId();
    }
}

if (!function_exists('get_real_telegram_chat_id')) {
    /**
     * @param Update $update
     *
     * @return int|null
     */
    function get_real_telegram_chat_id(Update $update) : ?int
    {
        return $update->getMessage()?->getFrom()->getId() ?? $update->getCallbackQuery()?->getFrom()->getId();
    }
}

if (!function_exists('get_telegram_user_firstname')) {
    /**
     * @param Update $update
     *
     * @return string|null
     */
    function get_telegram_user_firstname(Update $update) : ?string
    {
        return $update->getMessage()?->getFrom()->getFirstName() ?? $update->getCallbackQuery()?->getFrom()->getFirstName();
    }
}

if (!function_exists('get_telegram_user_lastname')) {
    /**
     * @param Update $update
     *
     * @return string|null
     */
    function get_telegram_user_lastname(Update $update) : ?string
    {
        return $update->getMessage()?->getFrom()->getLastName() ?? $update->getCallbackQuery()?->getFrom()->getLastName();
    }
}

if (!function_exists('get_telegram_username')) {
    /**
     * @param Update $update
     *
     * @return string|null
     */
    function get_telegram_username(Update $update) : ?string
    {
        return $update->getMessage()?->getFrom()->getUsername() ?? $update->getCallbackQuery()?->getFrom()->getUsername();
    }
}

if (!function_exists('create_user_password_by_telegram')) {
    /**
     * @param Update $update
     *
     * @return string
     */
    function create_user_password_by_telegram(Update $update) : string
    {
        $chat_id = get_telegram_chat_id($update);

        return "user_$($chat_id)}~\{$chat_id^";
    }
}

if (!function_exists('log_stack_trace')) {
    /**
     * @return array
     */
    function log_stack_trace() : array
    {
        $stack_trace = debug_backtrace();
        $log_message = [];

        foreach ($stack_trace as $stack_frame) {
            $file     = $stack_frame['file'] ?? '(no file)';
            $line     = $stack_frame['line'] ?? '(no line)';
            $function = $stack_frame['function'] ?? '(no function)';
            $type     = $stack_frame['type'] ?? ' - ';

            $log_message[] = sprintf("#%d %s:%s $type %s", $line, $file, $line, $function);
        }

        return $log_message;
    }
}

if (!function_exists('get_language_code_from_telegram')) {
    /**
     * @param Update $update
     *
     * @return string|null
     */
    function get_language_code_from_telegram(Update $update) : ?string
    {
        return $update->getMessage()?->getFrom()->getLanguageCode() ?? $update->getCallbackQuery()?->getFrom()->getLanguageCode();
    }
}

if (!function_exists('is_not_call_directly_from_user')) {
    /**
     * @param Update $update
     *
     * @return bool
     */
    function is_not_call_directly_from_user(Update $update) : bool
    {
        $chat_id          = get_telegram_chat_id($update);
        $telegram_user_id = get_real_telegram_chat_id($update);

        return $chat_id !== $telegram_user_id;
    }
}
