<?php

declare(strict_types = 1);

namespace App\TelegramBot\KeyboardButtons\Report;

use App\Contrancts\Telegram\TelegramKeyboardButtonInterface;
use App\TelegramBot\KeyboardButtons\Trait\KeyboardButtonTrait;
use Longman\TelegramBot\Entities\Update;

class ReportButton implements TelegramKeyboardButtonInterface
{
    use KeyboardButtonTrait;

    public function getName() : string
    {
        return __('telegram/index.text_get_report');
    }

    public function handle(Update $update) : void
    {
        // TODO: Implement handle() method.
    }
}
