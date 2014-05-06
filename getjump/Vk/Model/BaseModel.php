<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:51
 */

namespace getjump\Vk\Model;


use getjump\Vk\ApiResponse;

class BaseModel {

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __get($name) {
        return isset($this->data->$name) ? $this->data->$name : false;
    }

    public function __set($name, $value)
    {
        $this->data->$name = $value;
    }

    public function __isset($name) {
        return isset($this->data->$name);
    }
}