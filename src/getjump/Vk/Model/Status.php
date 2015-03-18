<?php

namespace getjump\Vk\Model;

/**
 * Class Status
 * Wrapper for accessing user status
 * @package getjump\Vk\Model
 */
class Status extends BaseModel
{
    /**
     * Return text status if instance was tried to used as string
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * Get current audio that user is listening for
     * @return bool|StatusAudio
     */
    public function getAudio()
    {
        if ($this->audio !== false) {
            return new StatusAudio($this->audio);
        }
        return false;
    }
}
