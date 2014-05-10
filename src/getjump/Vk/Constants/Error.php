<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 07.05.2014
 * Time: 17:21
 */

namespace getjump\Vk\Constants;


class Error
{
    const UNKNOWN = 1;
    const APP_DISABLED = 2;
    const UNKNOWN_METHOD = 3;
    const WRONG_SIGN = 4;
    const AUTH_FAILED = 5;
    const TOO_MANY_REQUESTS_IN_SECOND = 6;
    const INSUFFICIENT_PERMISSIONS = 7;
    const WRONG_REQUEST = 8;
    const TOO_MANY_SAME_ACTIONS = 9;

    const CAPTCHA = 14;
    const HTTP_AUTH = 16;
    const VALIDATION = 17;
    const NOT_STANDALONE = 20;
}
