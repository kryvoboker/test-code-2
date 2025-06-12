<?php

declare(strict_types = 1);

namespace App\Services\User;

use App\Enums\User\UserRoleEnum;
use App\Models\User\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Update;

class UserService
{
    private ?User                $user = null;

    /**
     * @param Update $update
     * @param array  $params
     *
     * @return User
     * @throws Exception
     */
    public function getOrCreateUserFromTelegram(Update $update, array $params = []) : User
    {
        if (isset($params['telegram_user_id'])) {
            $chat_id = (int)$params['telegram_user_id'];
        } else {
            $chat_id = get_telegram_chat_id($update);
        }

        if ($chat_id === null) {
            throw new Exception(__('user/index.error_telegram_chat_id'));
        }

        $user = new User()->getUserByTelegramChatId($chat_id);

        if ($user) {
            return $user;
        }

        return $this->fireRegisterUser($update, $chat_id);
    }

    /**
     * @param Update $update
     * @param int    $chat_id
     *
     * @return User
     * @throws Exception
     */
    private function fireRegisterUser(Update $update, int $chat_id) : User
    {
        $first_name = get_telegram_user_firstname($update);

        $user = User::create([
            'role'     => UserRoleEnum::User->value,
            'name'     => $first_name,
            'lastname' => get_telegram_user_lastname($update),
            'password' => create_user_password_by_telegram($update),
        ]);

        if ($user === null) {
            throw new Exception(__('user/index.error_user_create', [
                'chat_id' => $chat_id,
            ]));
        }

        $user->userToTelegram()->create([
            'chat_id'  => $chat_id,
            'username' => $first_name,
            'nickname' => get_telegram_username($update),
        ]);

        Log::channel('stack')->info(
            'User registered in Telegram bot Test code 2!',
            [
                'chat_id'  => $chat_id,
                'user_id'  => $user->id,
                'name'     => $user->name,
                'lastname' => $user->lastname,
                'locale'   => get_language_code_from_telegram($update),
            ]
        );

        return $user;
    }

    /**
     * @return bool
     */
    public function isBlocked() : bool
    {
        return $this->user?->role->value == UserRoleEnum::Blocked->value;
    }

    /**
     * @return User|null
     */
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     * @param Update $update
     * @param array  $params
     *
     * @return void
     * @throws Exception
     */
    public function fireSetUser(Update $update, array $params = []) : void
    {
        $this->user = $this->getOrCreateUserFromTelegram($update, $params);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function setUser(User $user) : void
    {
        $this->user = $user;
    }
}
