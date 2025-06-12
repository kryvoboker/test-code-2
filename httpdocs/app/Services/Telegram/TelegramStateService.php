<?php

declare(strict_types = 1);

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Cache;

class TelegramStateService
{
    /**
     * @param int    $chat_id
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get(int $chat_id, string $key, mixed $default = null) : mixed
    {
        return Cache::get("tg:$chat_id:$key", $default);
    }

    /**
     * @param int      $chat_id
     * @param string   $key
     * @param mixed    $value
     * @param int|null $ttl
     *
     * @return bool
     */
    public static function put(int $chat_id, string $key, mixed $value, ?int $ttl = null) : bool
    {
        if ($ttl === null) {
            $ttl = config('cache.life_time');
        }

        return Cache::put("tg:$chat_id:$key", $value, $ttl);
    }

    /**
     * @param int    $chat_id
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function pull(int $chat_id, string $key, mixed $default = null) : mixed
    {
        return Cache::pull("tg:$chat_id:$key", $default);
    }

    /**
     * @param int    $chat_id
     * @param string $key
     *
     * @return bool
     */
    public static function forget(int $chat_id, string $key) : bool
    {
        return Cache::forget("tg:$chat_id:$key");
    }
}
