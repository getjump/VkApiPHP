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
    private $params;

    private $lang = false;
    private $version = false;
    private $accessToken = false;

    public $callback = false;

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
        } else if($value) {
            $this->params[$key] = $value;
        }

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
        if (is_array($args))
            $this->params($args);
        $d = new RequestTransaction($methodName, $this->params, $this->accessToken, $this->callback);
        $this->reset();

        return $d;
    }

    public function reset()
    {
        $this->params = false;
        $this->param('lang', $this->lang);
        $this->param('v', $this->version);
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
        $this->param('lang', $this->lang);
        return $this;
    }

    /**
     * Set's api version
     * @param string $version
     * @return $this
     */
    public function apiVersion($version)
    {
        $this->params['v'] = $version;

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