<?php

namespace getjump\Vk\Model;


class Status extends BaseModel
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->text;
    }

    public function getAudio()
    {
        if ($this->audio !== false) {
            return new StatusAudio($this->audio);
        }
        return false;
    }
}
