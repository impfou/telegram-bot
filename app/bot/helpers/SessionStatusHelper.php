<?php

namespace Pcs\Bot\helpers;

class SessionStatusHelper
{
    const DEFAULT = 0;

    const START = 1;
    const SUBSCRIBE = 2;

    const USER_MANAGEMENT = 3;
    const MANAGE_REDIRECTS = 4;

    const ADDING_MAPPING = 5;
    const DELETING_MAPPING = 6;
    const EDITING_MAPPING = 7;
    const VIEW_MAPPING = 8;

    const ADDING_DIRECTIONS = 9;
    const DELETING_DIRECTIONS = 10;

    const VIEW_ALLOWED_DIRECTIONS_REDIRECTS = 11;
    const ADDING_EXTENSION_REDIRECT = 12;
}