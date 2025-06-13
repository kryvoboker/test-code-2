<?php

declare(strict_types = 1);

namespace App\Services\Api\Trello;

use App\Actions\Api\Telegram\SendMessageAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Exception\TelegramException;

class TrelloService
{
	const string TELEGRAM_GROUP_ID = '-1002586097522';

    /**
     * @param Request $request
     *
     * @return void
     * @throws TelegramException
     */
	public function handleList(Request $request) : void
	{
		if ($request->input('action') === null) {
			return;
		}

		switch ($request->input('action.type')) {
			case 'createCard':
				$this->handleCreateCard($request);

				break;
			case 'updateCard':
				$this->handleUpdateCard($request);

				break;
			default:
				Log::channel('stack')->warning(
					'Unhandled Trello action type',
					[
						'action_type' => $request->input('action.type'),
					]
				);
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return void
	 * @throws TelegramException
	 */
	private function handleCreateCard(Request $request) : void
	{
		if ($request->input('action.data.list.name') === null || $request->input('action.data.card.name') === null) {
			Log::channel('stack')->warning(
				'Trello webhook createCard request received without list name or card name',
				[
					'request' => $request->all(),
				]
			);
			return;
		}

		create_telegram_bot_instance();

		SendMessageAction::run(self::TELEGRAM_GROUP_ID, [
			'text'       => __('trello/handle_list.text_create_card', [
				'card_name' => $request->input('action.data.card.name', 'Unknown Card name'),
				'list_name' => $request->input('action.data.list.name', 'Unknown list name'),
			]),
			'parse_mode' => 'HTML',
		]);
	}

	/**
	 * @param Request $request
	 *
	 * @return void
	 * @throws TelegramException
	 */
	private function handleUpdateCard(Request $request) : void
	{
		if ($request->input('action.data.listBefore.name') === null || $request->input('action.data.listAfter.name') === null) {
			Log::channel('stack')->warning(
				'Trello webhook updateCard request received without listBefore or listAfter',
				[
					'request' => $request->all(),
				]
			);
			return;
		}

		create_telegram_bot_instance();

		SendMessageAction::run(self::TELEGRAM_GROUP_ID, [
			'text'       => __('trello/handle_list.text_update_card', [
				'card_name' => $request->input('action.data.card.name', 'Unknown Card'),
				'from'      => $request->input('action.data.listBefore.name', 'Unknown list before name'),
				'to'        => $request->input('action.data.listAfter.name', 'Unknown list after name'),
			]),
			'parse_mode' => 'HTML',
		]);
	}
}
