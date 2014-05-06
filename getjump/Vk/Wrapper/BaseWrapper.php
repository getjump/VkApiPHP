<?php

namespace getjump\Vk\Wrapper;

use getjump\Vk\ApiResponse; // todo Where is?
use getjump\Vk\Core;

class BaseWrapper {
    /**
     * @var Core;
     */
    protected $vk;

    /**
     * @param Core $vk
     */
    public function __construct(Core $vk) {
        if ($vk instanceof Core) {
            $this->vk = $vk;
        }
    }
} 