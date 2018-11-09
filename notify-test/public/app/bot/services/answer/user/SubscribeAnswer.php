<?php

namespace Pcs\Bot\services\answer\user;

use Pcs\Bot\helpers\SessionStatusHelper;
use Pcs\Bot\Logger;
use Pcs\Bot\repositories\ChatRepository;
use Pcs\Bot\repositories\SessionRepository;
use Pcs\Bot\repositories\UserRepository;
use TelegramBot\Api\Types\Message;

class SubscribeAnswer
{
    public static function get(Message $message)
    {
        $userRepository = new UserRepository();
        $chatRepository = new ChatRepository();
        $sessionRepository = new SessionRepository();

        if (is_null($message->getContact()) || is_null($message->getChat())) {
            return 'Непредвиденная ошибка, обратитесь к администратору';
        }

        $phoneNumber = $message->getContact()->getPhoneNumber();
        $chatID = $message->getChat()->getId();

        if (!empty($phoneNumber) && stripos($phoneNumber, '+') !== false) {
            $phoneNumber = str_replace('+', '', $phoneNumber);
        }

        $extension = $userRepository->getUserPhoneByPhone($phoneNumber);

        if (!empty($extension['extension']->extension)) {

            $chatRepository->saveChatID(
                $chatID,
                $extension['user']->id
            );
            $sessionRepository->setStatus($chatID, SessionStatusHelper::SUBSCRIBE);

            $answer = "Вы успешно подписались на оповещения о пропущенных звонках на номер {$extension['extension']->extension}". PHP_EOL .
                "Если это не ваш номер - обратитесь на Хотлайн";
        } else {
            $answer = "Данный номер мобильного телефона не занесен в базу данных сотрудников. Обратитесь на Хотлайн.";
        }

        return $answer;
    }
}