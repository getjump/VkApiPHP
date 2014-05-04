<?php
namespace getjump\Vk;


class ApiResponse {
    /**
     * @var Response
     */
    public $response = false;
    /**
     * @var bool|ErrorResponse
     */
    public $error = false;

    public function __construct($data, $callback = false) {
        $this->response = !isset($data->response) ? false : new Response($data->response, $callback);
        $this->error = !isset($data->error) ? false : new ErrorResponse($data->error);
    }

    public function each($callback = false)
    {
        return $this->response->each($callback);
    }

    public function getResponse() {
        return $this->response->getResponse();
    }
} 