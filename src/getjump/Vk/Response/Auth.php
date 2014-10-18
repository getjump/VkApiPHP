<?php

namespace getjump\Vk\Response;


class Auth {

    public $token = false;
    public $expiresIn = false;
    public $userId = false;

    public function __construct($token = false, $expiresIn = false, $userId = false)
    {
        $this->token = $token;
        $this->expiresIn = $expiresIn;
        $this->userId = $userId;
    }
} 