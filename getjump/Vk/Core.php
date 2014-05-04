<?php

namespace getjump\Vk;

class Core
{
    private $params;
    private $accessToken = false;

    public $callback = false;

    public $jsCallback = false;

    public function param($key,
                          $value, $defaultValue = false) {
        if(!$value && $defaultValue) {
            $value = $defaultValue;
        }
        $this->params[$key] = $value;

        return $this;
    }

    public function params($data)
    {
        foreach($data as $k => $v) {
            $this->param($k, $v);
        }

        return $this;
    }

    public function createAs($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param $methodName
     * @param bool $args
     * @return ApiResponse|RequestTransaction
     */
    public function request($methodName, $args = false) {
        if($args) $this->params($args);
        $d = new RequestTransaction($methodName, $this->params, $this->accessToken, $this->callback);
        $this->reset();
        return $d;
    }

    public function reset()
    {
        $this->params = false;
    }

    public function setToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function apiVersion($version)
    {
        $this->params['v'] = $version;
        return $this;
    }

    public static $instance;

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}