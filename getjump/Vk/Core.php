<?php

namespace getjump\Vk;

use Closure;
use getjump\Vk\Response\Api;

class Core {
    private $params;
    private $accessToken = false;

    public $callback = false;

    public $jsCallback = false;

    /**
     * @param mixed $key
     * @param mixed $value
     * @param bool $defaultValue
     * @return $this
     */
    public function param($key, $value, $defaultValue = false) {
        if (!$value && $defaultValue) {
            $value = $defaultValue;
        }
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function params(array $data) {
        foreach ($data as $k => $v) {
            $this->param($k, $v);
        }

        return $this;
    }

    /**
     * @param Closure $callback
     * @return $this
     */
    public function createAs(Closure $callback) {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @param string $methodName
     * @param bool|array $args
     * @return Api|RequestTransaction
     */
    public function request($methodName, $args = false) {
        if ($args)
            $this->params($args);
        $d = new RequestTransaction($methodName, $this->params, $this->accessToken, $this->callback);
        $this->reset();

        return $d;
    }

    public function reset() {
        $this->params = false;
    }

    /**
     * @param string $accessToken
     * @return $this
     */
    public function setToken($accessToken) {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function apiVersion($version) {
        $this->params['v'] = $version;

        return $this;
    }

    /**
     * @var Core
     */
    public static $instance;

    /**
     * @return Core
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}