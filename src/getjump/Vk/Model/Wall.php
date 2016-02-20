<?php

namespace getjump\Vk\Model;

/**
 * Class Wall
 * Used to work with wall.
 */
class Wall extends BaseModel
{
    /**
     * Return wall id.
     *
     * @return int|bool
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return true if this is repost.
     *
     * @return bool
     */
    public function isRepost()
    {
        return $this->copy_history !== false;
    }

    /**
     * Return recursive wall instance.
     *
     * @param int $id
     *
     * @return bool|Wall
     */
    public function getSource($id = 0)
    {
        if ($this->copy_history === false) {
            return false;
        }
        if (!isset($this->copy_history[$id])) {
            return false;
        }

        return new self($this->copy_history[0 + $id]);
    }
}
