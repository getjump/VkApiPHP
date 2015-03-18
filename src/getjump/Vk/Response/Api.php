<?php
namespace getjump\Vk\Response;

/**
 * Class Api
 * @package getjump\Vk\Response
 */
class Api
{
    /**
     * @var Response
     */
    public $response = false;
    /**
     * @var bool|Error
     */
    public $error = false;

    /**
     * @param $data
     * @param bool $callback
     */
    public function __construct($data, $callback = false)
    {
        $this->response = !isset($data->response) ? false : new Response($data->response, $callback);
        $this->error = !isset($data->error) ? false : new Error($data->error);
    }

    /**
     * Execute callable on every element of array
     * @param bool|callable $callback
     */
    public function each($callback = false)
    {
        $this->response->each($callback);
    }

    /**
     * Try to get one element
     * @return mixed
     */
    public function one()
    {
        return $this->response->one();
    }

    /**
     * Magic method for calling functions on api response
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->response, $name], $arguments);
    }

    /**
     * Magic method for accessing api response
     * @param $name
     * @return bool
     */
    public function __get($name)
    {
        return $this->response->{$name};
    }

    /**
     * Return ApiResponse
     * @return array|bool
     */
    public function getResponse()
    {
        return $this->response->getResponse();
    }
}
