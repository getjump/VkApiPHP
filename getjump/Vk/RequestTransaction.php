<?php
/**
 * Created by PhpStorm.
 * User: getju_000
 * Date: 03.05.14
 * Time: 12:19
 */

namespace getjump\Vk;

use Generator;
use getjump\Vk\Response\Api;

class RequestTransaction {
    /**
     * URL Api VK
     */
    const URL_VK_API = 'https://api.vk.com/method/';

    public $init = false;

    public $worker = false;

    /**
     * @var \GuzzleHttp\Client
     */
    public $guzzle = false;

    private $accessToken = false;

    public $methodName = false;
    public $args = array();
    public $callback = false;

    /**
     * @param string $methodName
     * @param bool $args
     * @param bool $accessToken
     * @param bool $callback
     */
    public function __construct($methodName, $args = false, $accessToken = false, $callback = false) {
        $this->methodName  = $methodName;
        $this->args        = $args;
        $this->accessToken = $accessToken;
        $this->callback    = $callback;
    }

    /**
     * @param int $count
     * @return Generator
     */
    public function batch($count = 10) {
        $this->args['count']  = $count;
        $this->args['offset'] = 0;

        while (true) {
            $d = $this->fetchData();
            yield $d;
            $everything = $d->response->count;
            $this->args['offset'] += $count;

            if ($this->args['offset'] >= $everything) {
                break;
            }
            //isset($this->args['offset']) ? $this->args['offset'] += $count : $this->args['offset'] = 0;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __get($name) {
        if (!$this->init) {
            return $this->fetchData()->$name;
        }

        return false;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return bool|mixed
     */
    function __call($name, array $arguments) {
        if (!$this->init) {
            return call_user_func_array([$this->fetchData(), $name], $arguments);
        }

        return false;
    }

    /**
     * @return Api
     */
    public function fetchData() {
        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $args = $this->args;
        if ($this->accessToken) {
            $args['access_token'] = $this->accessToken;
        }

        $data = $this->guzzle->post(self::URL_VK_API . $this->methodName, ['body' => $args])->json(['object' => true]);
        $c = new Api($data, $this->callback);

        //$c = new ApiResponse(json_decode(file_get_contents('https://api.vk.com/method/'.$this->methodName.'?'.$query)), $this->callback);
        return $c;
    }

    public function execute() {
        $this->fetchData();
    }

    /**
     * @return VkJs
     */
    public function toJs() {
        return new VkJs($this->methodName, $this->args, Core::getInstance());
    }
} 