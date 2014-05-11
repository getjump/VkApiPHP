<?php

namespace getjump\Vk\Model;

class StatusAudio extends BaseModel
{
    public function getUrl()
    {
        return $this->url;
    }

    public function getName()
    {
        return $this->artist . " - " . $this->title;
    }
}
