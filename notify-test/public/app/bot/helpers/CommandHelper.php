<?php

namespace Pcs\Bot\helpers;

class CommandHelper
{
    const START = 'start';
    const SUBSCRIBE = 'Подписаться';
    const UNSUBSCRIBE = 'Отписаться';
    const ADMIN = 'admin';
    const LIST = 'list';
    const ULIST = 'ulist';
    const USET = 'uset';
    const UNSET = 'unset';
    const BACK = 'Назад';
    const YES = 'Да';
    const NO = 'Нет';

    const USER_MANAGEMENT = 'Управление пользователями';
    const MANAGE_REDIRECTS = 'Управление переадресацией';

    const ADDING_MAPPING = 'Добавление сопоставления';
    const DELETING_MAPPING = 'Удаление сопоставления';
    const EDITING_MAPPING = 'Редактирование сопоставления';
    const VIEW_MAPPING = 'Просмотр сопоставлений';

    const ADDING_DIRECTIONS = 'Добавить направление';
    const DELETING_DIRECTIONS = 'Удалить направление';

    const VIEW_ALLOWED_DIRECTIONS_REDIRECTS = 'Разрешенные направления для переадресации';
    const ADDING_REDIRECT = 'Установка номера для переадресации';

    const ADDING_REDIRECT_ANOTHER_NUMBER = 'Установить на другой номер';

    const AUTO_RESPONDER = 'Автоответчик';
    const AUTO_RESPONDER_ON = 'Включить автоответчик';
    const AUTO_RESPONDER_OFF = 'Выключить автоответчик';

    const AUTO_RESPONDER_ON_NUMBER = 1;
    const AUTO_RESPONDER_OFF_NUMBER = 0;
}