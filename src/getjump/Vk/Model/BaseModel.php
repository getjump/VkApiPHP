<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:51
 */

namespace getjump\Vk\Model;

/**
 * Class BaseModel
 * Your models for data interpreting should extends this class
 * @package getjump\Vk\Model
 */
class BaseModel
{

    /**
     * Here we will store real data
     * @var
     */
    private $data;

    /**
     * Just a constructor
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * We are overriding get, so data will pulling from data array
     * @param string $name
     * @return bool
     */
    public function __get($name)
    {
        return isset($this->data->$name) ? $this->data->$name : false;
    }

    /**
     * We are overriding set, so data will writing to data array
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->data->$name = $value;
    }

    /**
     * We are overriding isset, so data will querying in data array
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }
}
