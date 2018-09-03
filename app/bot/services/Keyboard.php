<?php

namespace Pcs\Bot\services;

use Pcs\Bot\helpers\CommandHelper;
use Pcs\Bot\helpers\SessionStatusHelper;
use Pcs\Bot\repositories\ChatRepository;
use Pcs\Bot\repositories\SessionRepository;
use Pcs\Bot\services\keyboard\AddingRedirectKeyboard;
use Pcs\Bot\services\keyboard\ManageRedirectsKeyboard;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Keyboard
{
    private $chatRepository;
    private $sessionRepository;

    public function __construct()
    {
        $this->chatRepository = new ChatRepository();
        $this->sessionRepository = new SessionRepository();
    }

    public function getKeyboard(Message $message, $command = null)
    {
        if ($command == null) {
            $command = $message->getText();
        }

        $chatID = $message->getChat()->getId();

        switch ($command) {
            case CommandHelper::START:

                $chat = $this->chatRepository->getChatByChatID($chatID);

                if (!empty($chat->chat_id)) {
                    $keyboard = [
                        ["text" => CommandHelper::MANAGE_REDIRECTS]
                    ];
                } else {
                    $keyboard = [
                        ["text" => CommandHelper::SUBSCRIBE, 'request_contact' => true]
                    ];
                }

                return new ReplyKeyboardMarkup(
                    [
                        $keyboard
                    ],
                    true,
                    true
                );
                break;

            case CommandHelper::SUBSCRIBE:
                return new ReplyKeyboardMarkup(
                    [
                        [
                            ["text" => CommandHelper::MANAGE_REDIRECTS]
                        ]
                    ],
                    true,
                    true
                );
                break;

            case CommandHelper::USER_MANAGEMENT:
                $keyboard = new ReplyKeyboardMarkup(
                    [
                        [
                            ['text' => CommandHelper::VIEW_MAPPING],
                            ['text' => CommandHelper::ADDING_MAPPING],
                        ],
                        [
                            ['text' => CommandHelper::EDITING_MAPPING],
                            ['text' => CommandHelper::DELETING_MAPPING],
                        ]
                    ],
                    true,
                    true
                );
                return $keyboard;
                break;

            case CommandHelper::MANAGE_REDIRECTS:

                $keyboard = ManageRedirectsKeyboard::get($chatID);

                return new ReplyKeyboardMarkup(
                    $keyboard,
                    true,
                    true
                );
                break;

            case CommandHelper::VIEW_ALLOWED_DIRECTIONS_REDIRECTS:
                return new ReplyKeyboardMarkup(
                    [
                        [
                            ["text" => CommandHelper::BACK]
                        ]
                    ],
                    true,
                    true
                );
                break;

            case CommandHelper::ADDING_REDIRECT:
                $keyboard = AddingRedirectKeyboard::get();

                return new ReplyKeyboardMarkup(
                    $keyboard,
                    true,
                    true
                );
                break;

            case CommandHelper::ADDING_REDIRECT_ANOTHER_NUMBER:
                $keyboard = $keyboard = [
                    [
                        ["text" => CommandHelper::BACK]
                    ]
                ];

                return new ReplyKeyboardMarkup(
                    $keyboard,
                    true,
                    true
                );
                break;

            case CommandHelper::BACK:

                $keyboard = [];

                $currentStatus = $this->sessionRepository->getStatus($chatID);

                if ($currentStatus == SessionStatusHelper::MANAGE_REDIRECTS) {

                    $this->sessionRepository->setStatus($chatID, SessionStatusHelper::START);

                    $keyboard = [
                        [
                            ["text" => CommandHelper::MANAGE_REDIRECTS]
                        ]
                    ];
                } elseif ($currentStatus == SessionStatusHelper::VIEW_ALLOWED_DIRECTIONS_REDIRECTS) {
                    $this->sessionRepository->setStatus($chatID, SessionStatusHelper::MANAGE_REDIRECTS);

                    $keyboard = ManageRedirectsKeyboard::get($chatID);
                } elseif ($currentStatus == SessionStatusHelper::ADDING_EXTENSION_REDIRECT) {
                    $this->sessionRepository->setStatus($chatID, SessionStatusHelper::VIEW_ALLOWED_DIRECTIONS_REDIRECTS);

                    $keyboard = AddingRedirectKeyboard::get();
                } elseif ($currentStatus == SessionStatusHelper::ADDING_REDIRECT_ANOTHER_NUMBER) {
                    $this->sessionRepository->setStatus($chatID, SessionStatusHelper::ADDING_EXTENSION_REDIRECT);

                    $keyboard = AddingRedirectKeyboard::get();
                } elseif ($currentStatus == SessionStatusHelper::ADDING_REDIRECT_ANOTHER_NUMBER_SUCCESS) {
                    $this->sessionRepository->setStatus($chatID, SessionStatusHelper::START);

                    $keyboard = [
                        [
                            ["text" => CommandHelper::MANAGE_REDIRECTS]
                        ]
                    ];
                }

                return new ReplyKeyboardMarkup(
                    $keyboard,
                    true,
                    true
                );
                break;

            default:
                return null;
                break;
        }
    }
}