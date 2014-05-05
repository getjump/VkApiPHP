<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 02.05.14
 * Time: 16:25
 */

namespace getjump\Vk\Response;


class Response {
    /**
     * @var bool|array
     */
    public $items = false;
    public $count = false;

    /**
     * They can return just an response array, faggots
     * @var bool|array
     */
    public $data = false;

    public function __construct($data, $callback = false) {
        if(is_callable($callback) && isset($data->items))
        {
            foreach($data->items as $k => $d)
            {
                $this->items[] = call_user_func_array($callback, [$d]);
            }
        } else {
            $this->items = !isset($data->items) ? false : $data->items;
        }
        $this->count = !isset($data->count) ? false : $data->count;
        if(is_array($data) || !isset($data->items))
        {
            $this->count = sizeof($data);
            if(is_array($data) && is_callable($callback))
            {
                foreach($data as $k => $d)
                {
                    $this->data[] = call_user_func_array($callback, [$d]);
                }
            } else {
                $this->data = $data;
            }
        }
    }

    public function each($callback) {
        if(!is_callable($callback)) return;
        $data = false;
        $this->items ? $data = &$this->items : (!$this->data ? : $data = &$this->data);
        foreach($data as $k => $v)
        {
            call_user_func_array($callback, [$k, $v]);
        }
    }

    public function get($id = false)
    {
        if(!$id) {
            return $this->data[0];
        } else {
            return $this->data[$id];
        }
    }

    public function getResponse() {
        return $this->data;
    }
} 