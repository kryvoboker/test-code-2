<?php

declare(strict_types = 1);

namespace App\Contrancts\Telegram;

use Longman\TelegramBot\Entities\Update;

interface TelegramCommandInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param Update $update
     *
     * @return void
     */
    public function handle(Update $update) : void;
}
