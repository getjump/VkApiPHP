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
    }
} 