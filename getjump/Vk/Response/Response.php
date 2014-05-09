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
     * They can return just an response array, faggots
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
     * @param bool $id
     * @return mixed
     */
    public function get($id = false)
    {
        if (!$id) {
            if (is_array($this->data)) {
                return $this->data[0];
            } else {
                return $this->data;
            }
        } else {
            return $this->data[$id];
        }
    }

    public function __get($name)
    {
        if (!is_array($this->data)) {
            return $this->data->{$name};
        }

        return false;
    }

    public function one()
    {
        return $this->get();
    }

    /**
     * @return array|bool
     */
    public function getResponse()
    {
        return $this->data;
    }
}
