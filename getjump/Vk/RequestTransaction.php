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

/**
 * Class RequestTransaction
 * Is used as last front between API and Library
 * @package getjump\Vk
 */
class RequestTransaction
{
    /**
     * URL Api VK
     */
    const URL_VK_API = 'https://api.vk.com/method/';

    private $init = false;

    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzle = false;

    private $accessToken = false;

    private $methodName = false;
    private $args = array();
    private $callback = false;

    /**
     * @param string $methodName
     * @param bool $args
     * @param bool $accessToken
     * @param bool $callback
     */
    public function __construct($methodName, $args = false, $accessToken = false, $callback = false)
    {
        $this->methodName = $methodName;
        $this->args = $args;
        $this->accessToken = $accessToken;
        $this->callback = $callback;
    }

    /**
     * Batch method, for pulling just $count data at a time with foreach loop
     * @param int $count
     * @return Generator
     */
    public function batch($count = 10)
    {
        $this->args['count'] = $count;
        $this->args['offset'] = 0;

        while (true) {
            $d = $this->fetchData();
            yield $d;
            $everything = $d->response->count;
            $this->args['offset'] += $count;

            if ($this->args['offset'] >= $everything) {
                break;
            }
        }
    }

    /**
     * We are overriding get, so when we will try to access response, our data will get from a server
     * @param string $name
     * @return bool
     */
    public function __get($name)
    {
        if (!$this->init) {
            return $this->fetchData()->$name;
        }

        return false;
    }

    /**
     * We are overriding call, so when we will call to each, our data will get from a server
     * @param string $name
     * @param array $arguments
     * @return bool|mixed
     */
    public function __call($name, array $arguments)
    {
        if (!$this->init) {
            return call_user_func_array([$this->fetchData(), $name], $arguments);
        }

        return false;
    }

    /**
     * Querying API for a data
     * @return Api
     */
    private function fetchData()
    {
        if (!$this->guzzle) {
            $this->guzzle = new \GuzzleHttp\Client();
        }

        $args = $this->args;
        if ($this->accessToken) {
            $args['access_token'] = $this->accessToken;
        }

        $data = $this->guzzle->post(self::URL_VK_API . $this->methodName, ['body' => $args])->json(['object' => true]);
        $c = new Api($data, $this->callback);

        return $c;
    }

    /**
     * We want just execute, without getting any data
     */
    public function execute()
    {
        $this->fetchData();
    }

    /**
     * Will return VkJs object
     * @return VkJs
     */
    public function toJs()
    {
        return new VkJs(Core::getInstance(), $this->methodName, $this->args);
    }
}
