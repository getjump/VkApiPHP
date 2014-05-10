<?php

namespace getjump\Vk\Wrapper;

use getjump\Vk\Core;

/**
 * Class BaseWrapper
 * Your Wrappers should extends this class as part of architecture.
 * @package getjump\Vk\Wrapper
 */
class BaseWrapper
{
    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    /**
     * @var Core;
     */
    protected $vk;

    /**
     * @param Core $vk
     */
    public function __construct(Core $vk)
    {
        if ($vk instanceof Core) {
            $this->vk = $vk;
        }

        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }
    }
}
