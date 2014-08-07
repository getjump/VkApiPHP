<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 07.05.14
 * Time: 13:18
 */

namespace getjump\Vk\Exception;

use Exception;

class Error extends Exception
{
    /**
     * @var \getjump\Vk\Response\Error|bool
     */
    public $error = false;

    public function __construct($message = "", $code = 0, \getjump\Vk\Response\Error $e)
    {
        $this->error = $e;
        $this->message = $message;
        $this->code = $code;
    }
}
