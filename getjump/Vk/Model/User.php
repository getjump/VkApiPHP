<?php
namespace getjump\Vk\Model;


class User extends BaseModel {
    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
} 