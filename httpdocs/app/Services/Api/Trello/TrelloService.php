<?php

declare(strict_types = 1);

namespace App\Services\Api\Trello;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrelloService
{
    public function handleList(Request $request) : void
    {
        Log::channel('stack')->info(
            'Trello webhook list request received',
            [
                'request' => $request->all(),
            ]
        );
    }
}
