<?php

namespace getjump\Vk\Model;

/**
 * Class StatusAudio
 * Used to work with audio that user is listening for
 * @package getjump\Vk\Model
 */
class StatusAudio extends BaseModel
{
    /**
     * Return url
     * @return string|bool
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Return song artist concatenated with name using '-'
     * @return string
     */
    public function getName()
    {
        return $this->artist . " - " . $this->title;
    }
}
