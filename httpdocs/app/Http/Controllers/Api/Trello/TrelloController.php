<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Trello;

use App\Http\Controllers\Controller;
use App\Services\Api\Trello\TrelloService;
use Illuminate\Http\Request;

class TrelloController extends Controller
{
    public function __construct(private readonly TrelloService $trello_service) {}

    public function returnStatusOk() : void
    {
        return;
    }

    public function handleList(Request $request) : void
    {
        $this->trello_service->handleList($request);
    }
}
