<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:19
 */

namespace getjump\Vk\Response;


class Error {

    public $error_msg;
    public $error_code;
    public $request_params = array();

    const
        ERROR_CAPTCHA = 14,
        ERROR_HTTP_AUTH = 16,
        ERROR_VALIDATION = 17;

    public function __construct($error) {
        $this->error_msg = $error->error_msg;
        $this->error_code = $error->error_code;
        $this->request_params = $error->request_params;
    }

    public function getCode() {
        return $this->error_code;
    }

    public function getMessage() {
        return $this->error_msg;
    }

    public function getRequestParams() {
        return $this->request_params;
    }
} 