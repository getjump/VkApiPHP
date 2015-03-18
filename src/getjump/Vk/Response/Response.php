<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:25
 */

namespace getjump\Vk\Response;

use Closure;

/**
 * Class Response
 * @package getjump\Vk\Response
 */
class Response
{
    /**
     * @var bool|array
     */
    public $items = false;
    public $count = false;

    /**
     * They can return just an response array
     *
     * @var bool|array
     */
    public $data = false;

    /**
     * Response constructor
     * @param $data
     * @param bool|Closure $callback
     */
    public function __construct($data, $callback = false)
    {
        if (is_callable($callback) && isset($data->items)) {
            foreach ($data->items as $d) {
                $this->items[] = call_user_func_array($callback, [$d]);
            }
        } else {
            $this->items = !isset($data->items) ? false : $data->items;
        }
        $this->count = !isset($data->count) ? false : $data->count;
        if (is_array($data) || !isset($data->items)) {
            $this->count = sizeof($data);
            if (is_array($data) && is_callable($callback)) {
                foreach ($data as $d) {
                    $this->data[] = call_user_func_array($callback, [$d]);
                }
            } else {
                $this->data = $data;
            }
        }

        if(is_object($data) && is_callable($callback))
        {
            $this->data = call_user_func_array($callback, [$data]);
        }
    }

    /**
     * This method takes Closure as argument, so every element from response will go into this Closure
     * @param Closure $callback
     */
    public function each(Closure $callback)
    {
        if (!is_callable($callback)) {
            return;
        }
        $data = false;
        $this->items ? $data = & $this->items : (!$this->data ? : $data = & $this->data);
        foreach ($data as $k => $v) {
            call_user_func_array($callback, [$k, $v]);
        }
    }

    /**
     * This method will return one element if id is not specified or element of array otherwise
     * @param bool|int $id
     * @return mixed
     */
    public function get($id = false)
    {
        if (!$id) {
            if (is_array($this->data)) {
                return $this->data[0];
            } elseif(isset($this->items) && $this->items !== false) {
                return $this->items[0];
            } else {
                return $this->data;
            }
        } else {
            return $this->data[$id];
        }
    }

    /**
     * This magic method try to return field from response
     * @param $name
     * @return bool
     */
    public function __get($name)
    {
        if (!is_array($this->data)) {
            return $this->data->{$name};
        } elseif(sizeof($this->data) == 0 && is_object($this->data[0]))
        {
            return $this->data[0]->{$name};
        }

        return false;
    }

    /**
     * Just wrap over Response->get()
     * @return mixed
     */
    public function one()
    {
        return $this->get();
    }

    /**
     * This method return raw Response->data
     * @return array|bool
     */
    public function getResponse()
    {
        return $this->data;
    }
}
