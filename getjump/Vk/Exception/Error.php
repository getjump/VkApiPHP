<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 07.05.14
 * Time: 13:18
 */

namespace getjump\Vk\Exception;

use Exception;

class Error extends Exception {
    public function __construct($message = "", $code = 0) {
        $this->message = $message;
        $this->code = $code;
    }
} 