<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 04.05.14
 * Time: 13:47
 */

namespace getjump\Vk;

use getjump\Vk\Response\Api;
use stdClass;

/**
 * Class VkJs
 * Used to construct pseudo JavaScript
 * @package getjump\Vk
 */
class VkJs
{

    /**
     * Will contain pseudo JavaScript
     * @var bool|string
     */
    public $dataString = false;

    /**
     * Here we store instances of requests
     * @var bool|array
     */
    private $requests = false;

    /**
     * Instance of Core class
     * @var bool|Core
     */
    private $vk = false;

    /**
     * Callable that used against every element in returning array
     * @var bool
     */
    private $callback = false;

    /**
     * Just a constructor
     * @param Core $vk
     * @param string $methodName
     * @param bool|array $args
     */
    public function __construct(Core $vk, $methodName, $args = false)
    {
        $arg = [];
        if ($args) {
            foreach ($args as $k => $v) {
                $arg[] = sprintf('"%s" : "%s"', $k, $v);
            }
        }
        if ($vk instanceof Core) {
            $this->vk = $vk;
        }
        $this->dataString = sprintf("API.%s({%s})", $methodName, implode(', ', $arg));
    }

    /**
     * We wanna send our current VkJs to Vk execute
     * @return RequestTransaction|Api
     */
    public function execute()
    {
        $execute = $this->dataString;
        if ($this->requests) {
            foreach ($this->requests as $request) {
                $execute .= ',' . $request->dataString;
            }
            $execute = '[' . $execute . ']';

            if (!$this->callback && !$this->vk->jsCallback) {
                $this->vk->jsCallback = true;
                $oldCallback = $this->vk->callback;

                $this->callback = function ($data) use (&$oldCallback) {
                    $std = new stdClass();
                    $std->response = $data;
                    return new Api($std, $oldCallback);
                };

                $this->vk->createAs($this->callback);
            }
        }

        return $this->vk->request('execute', ['code' => sprintf('return %s;', $execute)]);
    }

    /**
     * Method will append one VkJs object, to another one
     * @param VkJs $js
     * @return $this
     */
    public function append(VkJs $js)
    {
        $this->requests[] = $js;

        return $this;
    }
}
