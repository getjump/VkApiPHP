<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 04.05.14
 * Time: 13:47
 */

namespace getjump\Vk;

class VkJs {

    /**
     * @var bool|string
     */
    public $dataString = false;

    /**
     * @var bool|array
     */
    private $requests = false;

    private $vk = false;

    private $callback = false;

    /**
     * @param $methodName
     * @param bool|array $args
     * @param Core $vk
     */
    public function __construct($methodName, $args = false, Core $vk)
    {
        $arg = [];
        if($args)
        {
            foreach($args as $k => $v)
            {
                $arg[] = sprintf('"%s" : "%s"', $k, $v);
            }
        }
        if($vk instanceof Core)
        {
            $this->vk = $vk;
        }
        $this->dataString = sprintf("API.%s({%s})", $methodName, implode(', ', $arg));
    }

    public function execute()
    {
        $execute = $this->dataString;
        if($this->requests)
        {
            $execute = '['.$this->dataString;
            foreach($this->requests as $request)
            {
                $execute .= ',' . $request->dataString;
            }
            $execute .= ']';
            if(!$this->callback  && !$this->vk->jsCallback)
            {
                $this->vk->jsCallback = true;
                $oldCallback = $this->vk->callback;
                $this->callback =
                    function($data) use(&$oldCallback){
                        $std = new \stdClass();
                        $std->response = $data;
                        return new Response\Api($std, $oldCallback);
                    };
                $this->vk->createAs($this->callback);
            }
        }

        return $this->vk->request('execute', ['code' => sprintf('return %s;', $execute)]);
    }

    public function append(VkJs $js)
    {
        $this->requests[] = $js;
        return $this;
    }
} 