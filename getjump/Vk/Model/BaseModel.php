<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:51
 */

namespace getjump\Vk\Model;

use getjump\Vk\ApiResponse; // todo Where is?

class BaseModel {

    public $data;

    /**
     * @param $data
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __get($name) {
        return isset($this->data->$name) ? $this->data->$name : false;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->data->$name = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->data->$name);
    }
}