<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Trello;

use App\Http\Controllers\Controller;
use App\Services\Api\Trello\TrelloService;
use Illuminate\Http\Request;
use Longman\TelegramBot\Exception\TelegramException;

class TrelloController extends Controller
{
    public function __construct(private readonly TrelloService $trello_service) {}

    /**
     * @return void
     */
    public function returnStatusOk() : void
    {
        // This method is used to return a 200 OK status for Trello webhook list requests.
        // It does not need to do anything else.
        http_response_code(200);
    }

    /**
     * @param Request $request
     *
     * @return void
     * @throws TelegramException
     */
    public function handleList(Request $request) : void
    {
        $this->trello_service->handleList($request);
    }
}
