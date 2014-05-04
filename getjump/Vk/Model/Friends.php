<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 03.05.14
 * Time: 12:43
 */

namespace getjump\Vk\Model;


class Friends extends BaseModel {
    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
} 