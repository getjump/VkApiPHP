<?php

namespace getjump\Vk\Model;


class Wall extends BaseModel
{
    public function getId()
    {
        return $this->id;
    }

    public function isRepost()
    {
        return $this->copy_history !== false;
    }

    public function getSource($id = 0)
    {
        if($this->copy_history === false) return false;
        if(!isset($this->copy_history[$id])) return false;
        return new Wall($this->copy_history[0 + $id]);
    }
}
