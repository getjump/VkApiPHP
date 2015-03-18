<?php

namespace getjump\Vk;

use Closure;
use getjump\Vk\Response\Api;

/**
 * Class Core
 * @package getjump\Vk
 */
class Core
{
    /**
     * Arguments array
     * @var array
     */
    private $params = [];

    /**
     * Define language that API will return responses in
     * @var bool|string
     */
    private $lang = false;
    /**
     * Define version of API interfaces
     * @var bool|string
     */
    private $version = false;
    /**
     * Define access token
     * @var bool|string
     */
    private $accessToken = false;

    /**
     * Callable that used against every element in returning array
     * @var bool|Callable
     */
    public $callback = false;

    /**
     * Callable that used against every element in returning array if VkJs was used
     * @var bool|Callable
     */
    public $jsCallback = false;

    /**
     * Set one param
     * @param mixed $key
     * @param mixed $value
     * @param bool $defaultValue
     * @return $this
     */
    public function param($key, $value, $defaultValue = false)
    {
        if (!$value && $defaultValue) {
            $value = $defaultValue;
        }

        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set many params
     * @param array $data
     * @return $this
     */
    public function params(array $data)
    {
        foreach ($data as $k => $v) {
            $this->param($k, $v);
        }

        return $this;
    }

    /**
     * Will set callback for element creation
     * @param Closure $callback
     * @return $this
     */
    public function createAs(Closure $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * API Request, will return RequestTransaction
     * @param string $methodName
     * @param bool|array $args
     * @return Api|RequestTransaction
     */
    public function request($methodName, $args = false)
    {
        if (is_array($args)) {
            $this->params($args);
        }

        $this->params = array_merge($this->params, $this->systemArgs());

        $d = new RequestTransaction($methodName, $this->params, $this->accessToken, $this->callback);
        $this->reset();

        return $d;
    }

    /**
     * Clear current params
     */
    public function reset()
    {
        $this->params = [];
    }

    /**
     * Set necessary arguments
     * @return array
     */
    private function systemArgs()
    {
        $array = [];

        if($this->lang)
            $array['lang'] = $array;
        if($this->version)
            $array['v'] = $this->version;
        return $array;
    }

    /**
     * Set's token
     * @param string $accessToken
     * @return $this
     */
    public function setToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * Set's api version
     * @param string $version
     * @return $this
     */
    public function apiVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @var Core
     */
    public static $instance;

    /**
     * We want same instance
     * @return Core
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
