<?php

namespace getjump\Vk\Wrapper;


use getjump\Vk\ApiResponse;

class BaseWrapper {
    /**
     * @var \getjump\Vk\Core;
     */
    protected $vk;

    public function __construct(\getjump\Vk\Core $vk) {
        if($vk instanceof \getjump\Vk\Core)
        {
            $this->vk = $vk;
        }
    }
} 