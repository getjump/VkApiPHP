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
    const ERROR_UNKNOWN = 1;
    const ERROR_APP_DISABLED = 2;
    const ERROR_UNKNOWN_METHOD = 3;
    const ERROR_WRONG_SIGN = 4;
    const ERROR_AUTH_FAILED = 5;
    const ERROR_TOO_MANY_REQUESTS_IN_SECOND = 6;
    const ERROR_INSUFFICIENT_PERMISSIONS = 7;
    const ERROR_WRONG_REQUEST = 8;
    const ERROR_TOO_MANY_SAME_ACTIONS = 9;

    const ERROR_CAPTCHA = 14;
    const ERROR_HTTP_AUTH = 16;
    const ERROR_VALIDATION = 17;
    const ERROR_NOT_STANDALONE = 20;
}
