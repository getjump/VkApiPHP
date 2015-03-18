<?php

namespace getjump\Vk\Response;

/**
 * Structure of auth token
 */
class Auth
{
    /** @var string token content */
    public $token = false;
    /** @var int time of life in seconds */
    public $expiresIn = false;
    /** @var int authorized user ID */
    public $userId = false;

    /**
     * @param bool|string $token token content
     * @param bool|int $expiresIn time of life in seconds
     * @param bool|int $userId authorized user ID
     */
    public function __construct($token = false, $expiresIn = false, $userId = false)
    {
        $this->token = $token;
        $this->expiresIn = $expiresIn;
        $this->userId = $userId;
    }
}
